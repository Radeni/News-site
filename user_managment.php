<?php
declare(strict_types=1);
require_once 'core/init.php';
$db = DBManager::getInstance();
$user = new UserManager();
if($user->data()->getTip() != 'glavni_urednik')
{
  Redirect::to('index.php');
}


// Execute the prepared SQL statement
$novinari = UserService::getInstance()->getNovinari($user->data()->getTip());
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="UTF-8">
    <title>Cars</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        .car-card {
            max-width: 18rem;
            margin-bottom: 1rem;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.2);
        }
        .car-card .card-img-top {
            height: 200px; /* Set a fixed height for the car image */
            object-fit: cover; /* Ensure the image covers the entire container */
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
    </style>
</head>
<body>

<?php
if (count($oglasi) > 0) {
    foreach ($oglasi as $oglas) {
        $korisnik = $db->get('korisnik', array('korisnik_id', '=', $oglas->korisnik_id))->first();
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
<div class="text-center">
    <a href="obrisi_oglas.php?id=' . $oglas->oglas_id . '" class="btn btn-danger">Delete</a>
</div>';
if ($oglas->admin_id == NULL){

echo '
<div class="text-center">
    <a href="odobri_oglas.php?id=' . $oglas->oglas_id . '" class="btn btn-dark">Approve</a>
</div>';
}
echo '
</div>
</div>
</div>
</div>
</div>';

    }
}
                
                    
                   
                    
?>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
