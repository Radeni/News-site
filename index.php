<?php
declare(strict_types=1);
require_once 'core/init.php';
$db = DBManager::getInstance();
// Execute the prepared SQL statement
$oglas = null;//$db->query("SELECT * FROM oglasi WHERE admin_id IS NOT NULL ORDER BY RAND() LIMIT 1")->first();
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org" xmlns:sec="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    p {
      color: #343a40;
    }

    .hero-section {
      background-size: cover;
      background-position: center;
      height: 500px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #ffffff;
    }

    .hero-section h1 {
      font-size: 48px;
      margin-bottom: 20px;
    }

    .hero-section p {
      font-size: 24px;
      margin-bottom: 40px;
    }

    body {
      background-color: #f7f7f7;
    }

    #addCarButton {
      margin-top: 20px;
    }

    #addCarButton .btn {
      font-weight: bold;
      font-size: 18px;
      padding: 10px 20px;
    }
    #adminButton {
      margin-top: 20px;
    }

    #adminButton .btn {
      font-weight: bold;
      font-size: 18px;
      padding: 10px 20px;
    }
  </style>
</head>
<body>

<section class="hero-section">
  <div class="container">
    <h1 class="display-4">Welcome to Used Cars</h1>
    <p class="lead">Discover amazing cars and find your perfect match.</p>
  </div>
</section>

<div class="row justify-content-center">
</div>
<?php
        $slika_id = $db->get('oglas_ima_sliku', array('oglas_id', '=', $oglas->oglas_id))->first()->slika_id;
        $slika_hash = $db->get('slika', array('slika_id', '=', $slika_id))->first()->hash;
        $link = "car-details.php?id=" . strval($oglas->oglas_id);
        echo '<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card car-card  mx-auto">';
echo '<img src="slike_oglasa/' . $slika_hash . '" alt="Car Picture" class="card-img-top">';
echo '<div class="card-body">';
echo '<h5 class="card-title"><b>Model:</b> ' . $oglas->marka . " " .  $oglas->model . '</h5>';
echo '<p class="card-text"><b>Year:</b> ' . $oglas->godiste . '.</p>';
echo '<p class="card-text"><b>Price:</b> ' . $oglas->cena . '</p>';
echo '<div class="text-center">
    <a href="' . $link . '" class="btn btn-dark">View Details</a>
</div>
</div>
</div>
</div>
</div>
</div>';
?>
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
