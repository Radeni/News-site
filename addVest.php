<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';
require_once 'service/UserRubrikaService.php';
require_once 'data/Vest.php';
require_once 'service/VestService.php';
require_once 'core/init.php';

  $config = HTMLPurifier_Config::createDefault();
  $config->set('HTML.DefinitionID', 'myCustomDefinition');
  $config->set('HTML.DefinitionRev', 1);
  $config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // Use a doctype that supports inline styles
  $config->set('HTML.SafeIframe', true);
  $config->set('URI.SafeIframeRegexp','%^(https://www.youtube.com/embed/)%'); // Allows YouTube iframes
  $config->set('CSS.AllowedProperties', array('position', 'padding-bottom', 'height', 'width', 'top', 'left', 'aspect-ratio'));
  $config->set('HTML.AllowedAttributes', 'iframe.src, iframe.frameborder, iframe.allowfullscreen, iframe.style, iframe.allow, div.style, div.data-oembed-url, img.src, img.alt, img.style, img.width, img.height');
  
$def = $config->maybeGetRawHTMLDefinition();
if ($def) {
    // Add the <figure> element
    $def->addElement(
        'figure',   // Tag name
        'Block',    // Content set
        'Optional: (figcaption, Flow) | Flow',
        'Common',   // Attribute collection
        array()     // Attributes
    );

    // Add custom attributes to existing elements
    $def->addAttribute('div', 'data-oembed-url', 'Text');
    
    // Allow the <iframe> element with specific attributes
    $def->addElement(
        'iframe',   // Tag name
        'Inline',   // Content set
        'Empty',    // Allowed children
        'Common',   // Attribute collection
        array(      // Attributes
            'src' => 'URI#embedded', // Allows embedding URLs, which might need further customization
            'frameborder' => 'Text',
            'allowfullscreen' => 'Bool',
            'allow' => 'Text',
            'style' => 'Text',
        )
    );
    $img = $def->addBlankElement('img');
    $img->attr['style'] = new HTMLPurifier_AttrDef_Enum(array('aspect-ratio'));
    $img->attr['width'] = 'Length';
    $img->attr['height'] = 'Length';
    $img->attr['src'] = new HTMLPurifier_AttrDef_URI();
    $style = $def->info_global_attr['style'] = new HTMLPurifier_AttrDef_CSS();
}
$purifier = new HTMLPurifier($config);


$userManager = new UserManager();
if (!$userManager->isLoggedIn()) {
    Redirect::to('index.php');
}
$idKorisnik = $userManager->data()->getIdKorisnik();
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check(
            $_POST, array(
            'naslov' => array(
                'required' => true,
                'max' => 100
            ),
            'tagovi' => array(
                'required' => true,
                'max' => 100
            )
            )
        );

        if ($validation->passed()) {
            // update
            try {
                $vest = new Vest(null, Input::get('naslov'), '', Input::get('tagovi'),date('Y-m-d'),0,0,'draft',Input::get('rubrika'), $idKorisnik);
                $vest_id = VestService::getInstance()->createVest($vest);
                Redirect::to('editvest.php?id=' . $vest_id);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org" xmlns:sec="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <title>Dodaj vest</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- CKEditor-->
  <script src="ckeditor5-41.1.0/build/ckeditor.js"></script>
  <style>
    .navbar {
      background-color: #212529;
    }

    .navbar-brand {
      color: #f8f9fa;
      font-weight: bold;
    }

    .navbar-nav .nav-link {
      color: #f8f9fa;
    }

    .navbar-nav .nav-link:hover {
      color: #adb5bd;
    }

    .navbar-nav .active {
      font-weight: bold;
    }

    h1 {
      color: #343a40;
      font-weight: bold;
    }

    label {
      color: #343a40;
    }

    .form-control {
      border-color: #343a40;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0069d9;
    }

    body {
      background-color: #f7f7f7;
    }
    .input-container {
    max-width: 350px;
    margin: 0 auto;
  }
  </style>
</head>
<body>

<div class="container">
  <div id="authenticatedDiv">
    <!-- Only authenticated users can access this form -->
    <form id="carForm" enctype="multipart/form-data" method="post" action="">
      <div class="input-container">
        <div class="mb-3">
          <label for="naslov" class="form-label">Naslov:</label>
          <input type="text" class="form-control" id="naslov" name="naslov" required>
        </div>
        
        <div class="mb-3">
          <label for="tagovi" class="form-label">Tagovi:</label>
          <input type="text" class="form-control" id="tagovi" name="tagovi" required>
        </div>
        
        <div class="mb-3">
        <?php
            $rubrike = UserRubrikaService::getInstance()->getUserRubrikas($idKorisnik);
            echo '<select id="rubrika" name="rubrika" style="width: 100%;">';
            if(count($rubrike) > 0) {
                foreach($rubrike as $rubrika) {
                    echo '<option value="'. $rubrika->getIdRubrika() .'"'. $selected .'>'. $rubrika->getIme() .'</option>';
                }
            } else {
                echo '<option disabled>NI JEDNA RUBRIKA VAM NIJE DODELJENA!!!!!!!!!!</option>';
            }
            echo '</select>';
        ?>
        </div>
        <div class="text-center">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit" class="btn btn-dark">Dodaj Vest</button>
        </div>
      </div>
    </form>
    <div class="row my-2"></div>
  </div>
</div>
<!-- Include Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    var entryDropdown = $('#entryDropdown');
      entryDropdown.html('<a class="nav-link dropdown-toggle" href="#" id="entryDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">User</a>' +
                         '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="entryDropdown">' +
                         '  <a class="dropdown-item" href="login.php">Login</a>' +
                         '  <a class="dropdown-item" href="register.php">Register</a>' +
                         '</div>');
  });
</script>
</body>
</html>
