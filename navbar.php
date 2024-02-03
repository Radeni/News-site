<?php
declare(strict_types=1);
require_once 'core/init.php';
$user = new UserManager();
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css">
        <title>Vesti365</title>
        <link rel="icon" type="image/x-icon" href="./images/icons/car-icon.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Custom CSS -->
  
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <style>
    .navbar {
      background-color: #ff0000;
    }

    .navbar-brand {
      color: #ffffff;
      font-weight: bold;
    }

    .navbar-nav .nav-link {
      color: #ffffff;
    }

    .navbar-nav .nav-link:hover {
      color: #383838;
    }

    .navbar-nav .active {
      font-weight: bold;
    }
    </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Vesti-365</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Naslovna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cars.php">Pretraga</a>
        </li>
        <?php
        if(!$user->isLoggedIn()) { 
            echo '<a class="nav-link" href="login.php">Prijava</a>';
        }
        else {
            
            if($user->data()->getTip() == 'glavni_urednik')
            {
              echo '<a class="nav-link" href="user_management.php">Upravljaj novinarima</a>';
              echo '<a class="nav-link" href="register.php">Registruj novinara</a>';
            } else
            {
              echo '<a class="nav-link" href="addcar.php">Napisi clanak</a>';
              echo '<a class="nav-link" href="cars_user.php">Moji clanci</a>';
            }
            echo '<a class="nav-link" href="logout.php">Logout</a>';
            
        }
        
        
        ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>