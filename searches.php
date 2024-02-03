<?php
declare(strict_types=1);
require_once 'core/init.php';
$db = DBManager::getInstance();
$user = new User();
require_once 'navbar.php';

?>

<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <!-- Include Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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
<table>
    <tr>
        <th>#</th>
        <th>Manufacturer</th>
        <th>Model</th>
        <th>Year from</th>
        <th>Year to</th>
        <th>Mileage</th>
        <th>Price from</th>
        <th>Price to</th>
        <th>Drive type</th>
        <th>Gearbox type</th>
        <th></th>
        <th></th>
</tr>
<?php
$pretrage = $db->get('pretraga', array('korisnik_id', '=', $user->data()->korisnik_id))->results();
$iter = 1;
if (count($pretrage) > 0) {
    foreach ($pretrage as $pretraga) {
        $marka = $pretraga->marka;
        $model = $pretraga->model;
        $godiste_od = $pretraga->godiste_od;
        $godiste_do = $pretraga->godiste_do;
        $kilometraza_do = $pretraga->kilometraza_do;
        $cena_od = $pretraga->cena_od;
        $cena_do = $pretraga->cena_do;
        $pogon = $pretraga->pogon;
        $menjac = $pretraga->menjac;

        $searchParams = http_build_query(array(
            'marka' => $marka,
            'model' => $model,
            'godiste_od' => $godiste_od,
            'godiste_do' => $godiste_do,
            'kilometraza_do' => $kilometraza_do,
            'cena_od' => $cena_od,
            'cena_do' => $cena_do,
            'pogon' => $pogon,
            'menjac' => $menjac
        ));

        $link = 'cars.php?' . $searchParams;
        $linkDelete = 'obrisi_pretragu.php?id='.$pretraga->pretraga_id;
        echo '<tr>
        <td>'. $iter++ . '</td>
        <td>'. $pretraga->marka. '</td>
        <td>'. $pretraga->model. '</td>
        <td>'. $pretraga->godiste_od. '</td>
        <td>'. $pretraga->godiste_do. '</td>
        <td>'. $pretraga->kilometraza_do. '</td>
        <td>'. $pretraga->cena_od. '</td>
        <td>'. $pretraga->cena_do. '</td>
        <td>'. $pretraga->pogon. '</td>
        <td>'. $pretraga->menjac. '</td>
        <td>
        <a href="'.$link.'"><button type="button" class="btn btn-dark">Search</button></a>
        </td>
        <td>
        <a href="'.$linkDelete.'"><button type="button" class="btn btn-danger">Delete Search</button></a>
        </td>
        </tr>';
    }
}
?>
</table>
</div>
</body>
</html>
