<?php
declare(strict_types=1);
require_once 'core/init.php';
if (!Input::exists('get')) {
    Redirect::to('index.php');
}
$user = new User();
$oglas_id = Input::get('id');
$db = DBManager::getInstance();
$oglas = $db->query('SELECT * FROM oglasi WHERE oglas_id = ?', array($oglas_id))->first();

if (!$oglas->admin_id)
{
    if (!$user->isLoggedIn())
    {
        Redirect::to(404);
    }
    else
    {
        if ($user->permissionLevel() == 1)
        {
            if ($oglas->korisnik_id != $user->data()->korisnik_id)
            {
                Redirect::to(404);
            }
        }
        elseif ($user->permissionLevel() != 2)
        {
            Redirect::to(404);
        }
    }
}

$slike = $db->query('SELECT hash FROM slika s JOIN oglas_ima_sliku os ON os.slika_id=s.slika_id JOIN oglasi o ON o.oglas_id = os.oglas_id WHERE o.oglas_id = ?', array($oglas_id))->results();
$prodavac = $db->get('korisnik', array('korisnik_id', '=', $oglas->korisnik_id))->first();
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
  <meta charset="UTF-8">
  <title>Car Details</title>
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
    .swiper-container {
            width: 100%;
            height: 100vh; /* Adjust the height as needed */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            max-width: 100%;
            max-height: 50%;
            object-fit: contain;
        }
  </style>
</head>
<body>

<div class="container">
  <div class="row mt-4">
  <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                if (!empty($slike)) {
                    foreach ($slike as $slika) {
                        echo '<div class="swiper-slide"><img src="./slike_oglasa/'. $slika->hash .'"></div>';
                    }
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Car Details</h5>
          <hr>
          <p class="card-text">Manufacturer: <?php echo escape($oglas->marka) ?></p>
          <p class="card-text">Model: <?php echo escape($oglas->model) ?></p>
          <p class="card-text">Year: <?php echo $oglas->godiste ?></p>
          <p class="card-text">Mileage: <?php echo $oglas->kilometraza ?></p>
          <p class="card-text">Price: <?php echo $oglas->cena ?></p>
          <p class="card-text">Drive Type: <?php echo escape($oglas->pogon) ?></p>
          <p class="card-text">Gearbox Type: <?php echo escape($oglas->menjac) ?></p>
          <p class="card-text">Damage: <?php echo escape($oglas->damage) ?></p>
          <p class="card-text">Description: <?php echo escape($oglas->opis_oglasa) ?></p>
          <p class="card-text">User Name: <?php echo escape($prodavac->ime).' '.escape($prodavac->prezime)  ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
//'.$oglas->model.'
$oglasalt = $db->get('oglasi', array('model', '=', $oglas->model))->randresult();
        $slika_id = $db->get('oglas_ima_sliku', array('oglas_id', '=', $oglasalt->oglas_id))->first()->slika_id;
        $slika_hash = $db->get('slika', array('slika_id', '=', $slika_id))->first()->hash;
        $link = "car-details.php?id=" . strval($oglasalt->oglas_id);
        echo '<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card car-card  mx-auto">';
echo '<img src="slike_oglasa/' . $slika_hash . '" alt="Car Picture" class="card-img-top">';
echo '<div class="card-body">';
echo '<h5 class="card-title"><b>Model:</b> ' . $oglasalt->marka . " " .  $oglasalt->model . '</h5>';
echo '<p class="card-text"><b>Year:</b> ' . $oglasalt->godiste . '.</p>';
echo '<p class="card-text"><b>Price:</b> ' . $oglasalt->cena . '</p>';
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
