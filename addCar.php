<?php
declare(strict_types=1);
require_once 'service/UserRubrikaService.php';
require_once 'data/Vest.php';
require_once 'service/VestService.php';
require_once 'core/init.php';

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
            'tekst' => array(
                'required' => true,
                'max' => 3000
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
                $vest = new Vest(null, Input::get('naslov'), Input::get('tekst'), Input::get('tagovi'),date('Y-m-d'),0,0,'draft',Input::get('rubrika'), $idKorisnik);
                VestService::getInstance()->createVest($vest);
                die();
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
  <title>Add New Car</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Custom CSS -->
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
  <div class="text-center">
    <h1 class="mt-4">Add New Car</h1>
  </div>
  <div id="authenticatedDiv">
    <!-- Only authenticated users can access this form -->
    <form id="carForm" enctype="multipart/form-data" method="post" action="">
      <div class="input-container">
        <div class="mb-3">
          <label for="naslov" class="form-label">Naslov:</label>
          <input type="text" class="form-control" id="naslov" name="naslov" required>
        </div>
        <div class="mb-3">
          <label for="tekst" class="form-label">Tekst:</label>
          <input type="text" class="form-control" id="tekst" name="tekst" required>
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
        <button type="submit" class="btn btn-dark">Add Vest</button>
        </div>
      </div>
    </form>
    <div class="row my-2"></div>
  </div>
  <div id="notAuthenticatedDiv" style="display: none;">
    <!-- Show a message or redirect to login page for non-authenticated users -->
    <div class="text-center">
      <p>Please <a th:href="@{/login}">login</a> to add a new car.</p>
    </div>
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
