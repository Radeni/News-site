<?php
declare(strict_types=1);
require_once 'core/init.php';
require_once 'service/userservice.php';
/*if (!Input::exists('get')) {
    Redirect::to('index.php');
}*/
$user = new UserManager();
$korisnik_id = Input::get('id');
$korisnik = UserService::getInstance()->getUserById($korisnik_id);
$db = DBManager::getInstance();
//$oglas = $db->query('SELECT * FROM oglasi WHERE oglas_id = ?', array($oglas_id))->first();


require_once 'navbar.php';

?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
  <meta charset="UTF-8">
  <title>Upravljaj korisnikom</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <style>
    body {
      background-color: #f7f7f7;
    }

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
      margin-top: 20px;
    }

    #carousel-container {
      width: 400px;
      height: 300px;
      margin: 0 auto;
    }

    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .card {
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .card-text {
      margin-bottom: 0.5rem;
    }

    .card-text span {
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Upravljaj korisnikom:</h5>
          <hr> 
          <p class="card-text">User Name: <?php echo escape($korisnik->getUsername())?></p>
          <p class="card-text">Ime: <?php echo escape($korisnik->getIme()) ?></p>
          <p class="card-text">Prezime: <?php echo escape($korisnik->getPrezime()) ?></p>
          <p class="card-text">Telefon: <?php echo $korisnik->getTelefon() ?></p>
          <p class="card-text">Tip: <?php echo $korisnik->getTip() ?></p>
          <div class="text-center">
            <a href="edit_user_data.php?id=<?php echo $korisnik_id?>" class="btn btn-dark">Izmeni Podatke</a>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script defer>
            var swiper = new Swiper('.swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
            const togglerLeft = document.querySelector(".toggler-one")
const togglerRight = document.querySelector(".toggler-two")
const adImage = document.querySelector(".ad-image")
const photoNum = document.querySelector(".num-of-photo")
let numDisplayed = 0
const imagesArray = ["./images/car_images/car1.jpg", "./images/car_images/car2.jpg", "./images/car_images/car3.jpg"]
photoNum.textContent = (numDisplayed+1) + "/" + (imagesArray.length)

function changeImage(imagesArray, numDisplayed) {
    adImage.src = imagesArray[numDisplayed]
    photoNum.textContent = (numDisplayed+1) + "/" + (imagesArray.length)
}

togglerLeft.addEventListener("click", function() {
    if (numDisplayed == 0) {
        numDisplayed = imagesArray.length - 1
    } else {
        numDisplayed-- 
    }
    changeImage(imagesArray, numDisplayed)
})

togglerRight.addEventListener("click", function() {
    if (numDisplayed == 2) {
        numDisplayed = 0
    } else {
        numDisplayed++
    }
    changeImage(imagesArray, numDisplayed) 
})
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
