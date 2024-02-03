<?php
declare(strict_types=1);
require_once 'core/init.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check(
            $_POST, array(
            'marka' => array(
                'required' => true,
                'max' => 45
            ),
            'model' => array(
                'required' => true,
                'max' => 45
            ),
            'godiste' => array(
                'required' => true,
                'numeric' => true
            ),
            'kilometraza' => array(
                'required' => true,
                'numeric' => true
            ),
            'cena' => array(
                'required' => true,
                'numeric' => true
            ),
            'pogon' => array(
                'required' => true,
                'max' => 45
            ),
            'menjac' => array(
                'required' => true,
                'max' => 45
            ),
            'opis_oglasa' => array(
                'required' => true,
                'max' => 1000
            ),
            'damage' => array(
              'required' => true,
              'max' => 45
             )
            )
        );

        if ($validation->passed()) {
            // update
            try {
                $db = DBManager::getInstance();
                $fileNames = array_filter($_FILES['fileToUpload']['name']);
                $target_dir = "slike_oglasa/";
                if (!empty($fileNames)) {
                    foreach ($_FILES['fileToUpload']['name'] as $key => $val) {
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$key]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]);
                        $error = '';
                        if ($check !== false) {
                            $uploadOk = 1;
                        } else {
                            $error .= "File is not an image./n";
                            $uploadOk = 0;
                        }
                        // Check file size
                        if ($_FILES["fileToUpload"]["size"][$key] > 5000000000) { //Sredi ovaj limit
                            $error .= "Sorry, your file is too large./n";
                            $uploadOk = 0;
                        }

                        // Allow certain file formats
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                            $error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed./n";
                            $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo $error;
                            break;
                        } else {
                            if (!file_exists($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }
                            $newfilename = $target_dir . $_FILES["fileToUpload"]["name"][$key];
                            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $newfilename)) {
                                echo 'Doslo je do nepoznate greske tokom dodavanja slika<br>';
                                break;
                            }
                        }
                    }
                }
                else {
                    echo 'Slika je obavezna<br>';
                    return;
                }//IMPROVE ERROR HANDLING
                $db->insert(
                    'oglasi', array(
                        'marka' => Input::get('marka'),
                        'model' => Input::get('model'),
                        'godiste' => Input::get('godiste'),
                        'kilometraza' => Input::get('kilometraza'),
                        'cena' => Input::get('cena'),
                        'pogon' => Input::get('pogon'),
                        'menjac' => Input::get('menjac'),
                        'opis_oglasa' => Input::get('opis_oglasa'),
                        'damage' => Input::get('damage'),
                        'korisnik_id' => $user->data()->korisnik_id
                        
                    )
                );
                $oglas_id = $db->query('SELECT oglas_id FROM oglasi ORDER BY oglas_id DESC LIMIT 1')->first()->oglas_id;
                foreach ($fileNames as $filename) { //TODO: Fix filename issue when there is a . in the filename
                    $sha1 = sha1_file($target_dir . $filename);
                    rename($target_dir . $filename, $target_dir . $sha1 . '.' . explode(".", $filename)[1]);
                    $slika = $db->get('slika', array('hash', '=', $sha1 . '.' . explode(".", $filename)[1]));
                    $broj_slika = $slika->count();
                    if ($broj_slika == 0) {
                        $db->insert(
                            'slika', array(
                            'hash' => $sha1 . '.' . explode(".", $filename)[1]
                            )
                        );
                        $slika_id = $db->query('SELECT slika_id FROM slika ORDER BY slika_id DESC LIMIT 1')->first()->slika_id;
                        $db->insert(
                            'oglas_ima_sliku', array(
                            'oglas_id' => $oglas_id,
                            'slika_id' => $slika_id
                            )
                        );
                    } else {
                        $slika_id = $slika->first()->slika_id;
                        $db->insert(
                            'oglas_ima_sliku', array(
                            'oglas_id' => $oglas_id,
                            'slika_id' => $slika_id
                            )
                        );
                    }
                }
                $link = "car-details.php?id=" . strval($oglas_id);
                Redirect::to($link);
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
          <label for="manufacturer" class="form-label">Manufacturer:</label>
          <input type="text" class="form-control" id="marka" name="marka" required>
        </div>
        <div class="mb-3">
          <label for="model" class="form-label">Model:</label>
          <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="mb-3">
          <label for="year" class="form-label">Year:</label>
          <input type="number" class="form-control" id="godiste" name="godiste"  min="0" onkeyup="if(value<0) value=0;" required>
        </div>
        <div class="mb-3">
          <label for="mileage" class="form-label">Mileage:</label>
          <input type="number" class="form-control" id="kilometraza" name="kilometraza" min="0" onkeyup="if(value<0) value=0;" required>
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Price:</label>
          <input type="number" class="form-control" id="cena" name="cena"  min="0" onkeyup="if(value<0) value=0;" required>
        </div>
        <div class="mb-3">
          <label for="driveType" class="form-label">Drive Type:</label>
          <select class="form-select" id="pogon" name="pogon" required>
            <option value="FWD">Front-Wheel Drive (FWD)</option>
            <option value="RWD">Rear-Wheel Drive (RWD)</option>
            <option value="AWD">All-Wheel Drive (AWD)</option>
            <option value="4WD">Four-Wheel Drive (4WD)</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="gearboxType" class="form-label">Gearbox Type:</label>
          <select class="form-select" id="menjac" name="menjac" required>
            <option value="Manual">Manual Transmission</option>
            <option value="Automatic">Automatic Transmission</option>
            <option value="CVT">Continuously Variable Transmission (CVT)</option>
            <option value="DCT">Dual-Clutch Transmission (DCT)</option>
            <option value="AMT">Automated Manual Transmission (AMT)</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="damage" class="form-label">Damage:</label>
          <select class="form-select" id="damage" name="damage" required>
            <option value="none">Not damaged</option>
            <option value="driveable">Damaged (Driveable)</option>
            <option value="notdriveable">Damaged (Not driveable)</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description:</label>
          <textarea class="form-control" id="opis_oglasa" name="opis_oglasa" required></textarea>
        </div>
        <div class="mb-3">
          <label for="pictures" class="form-label">Pictures:</label>
          <input type="file" class="form-control" id="fileToUpload" name="fileToUpload[]" multiple required>
        </div>
        <div class="text-center">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">  
        <button type="submit" class="btn btn-dark">Add Car</button>
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
<script>function handleFileSelection(event) {
  var fileInput = event.target;
  var fileChosenSpan = document.getElementById("file-chosen");
  
  if (fileInput.files.length > 0) {
      fileChosenSpan.textContent = fileInput.files.length + " file(s) selected";
  } else {
      fileChosenSpan.textContent = "";
  }
}
</script>
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
