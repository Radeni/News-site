<?php
declare(strict_types=1);
require_once 'core/init.php';
$db = DBManager::getInstance();
$user = new User();
$marka = "%" . strtolower(Input::get('marka')) . "%";
$model = "%" . strtolower(Input::get('model')) . "%";
$pogon = "%" . strtolower(Input::get('pogon')) . "%";
$menjac = "%" . strtolower(Input::get('menjac')) . "%";
$damage = "%" . strtolower(Input::get('damage')) . "%";

$godiste_od = !empty(Input::get('godiste_od')) ? Input::get('godiste_od') : PHP_INT_MIN;
$godiste_do = !empty(Input::get('godiste_do')) ? Input::get('godiste_do') : PHP_INT_MAX;
$kilometraza_od = 0;
$kilometraza_do = !empty(Input::get('kilometraza_do')) ? Input::get('kilometraza_do') : PHP_INT_MAX;
$cena_od = !empty(Input::get('cena_od')) ? Input::get('cena_od') : PHP_INT_MIN;
$cena_do = !empty(Input::get('cena_do')) ? Input::get('cena_do') : PHP_INT_MAX;
$sql = "SELECT * FROM oglasi WHERE admin_id is NOT NULL";

$bindings = [];

if (!empty($marka)) {
  $sql .= " AND LOWER(marka) LIKE ?";
  $bindings[] = $marka;
}

if (!empty($model)) {
  $sql .= " AND LOWER(model) LIKE ?";
  $bindings[] = $model;
}

$sql .= " AND godiste BETWEEN ? AND ?";
$bindings[] = $godiste_od;
$bindings[] = $godiste_do;

$sql .= " AND kilometraza BETWEEN ? AND ?";
$bindings[] = $kilometraza_od;
$bindings[] = $kilometraza_do;

$sql .= " AND cena BETWEEN ? AND ?";
$bindings[] = $cena_od;
$bindings[] = $cena_do;

if (!empty($pogon)) {
  $sql .= " AND LOWER(pogon) LIKE ?";
  $bindings[] = $pogon;
}
if (!empty($damage)) {
    $sql .= " AND LOWER(damage) LIKE ?";
    $bindings[] = $damage;
  }
if (!empty($menjac)) {
  $sql .= " AND LOWER(menjac) LIKE ?";
  $bindings[] = $menjac;
}

// Execute the prepared SQL statement
$oglasi = $db->query($sql, $bindings)->results();
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="searchForm" method="get" action="">
                <div class="row text-center">
                    <h1>Search</h1>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="model">Manufacturer:</label>
                            <input type="text" class="form-control" id="marka" name="marka" value="<?php echo Input::get('marka'); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="model">Model:</label>
                            <input type="text" class="form-control" id="model" name="model" value="<?php echo Input::get('model'); ?>" >
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="startYear">Start Year:</label>
                            <input type="number" class="form-control" id="godiste_od" name="godiste_od" value="<?php echo Input::get('godiste_od'); ?>" min="0" onkeyup="if(value<0) value=0;">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="endYear">End Year:</label>
                            <input type="number" class="form-control" id="godiste_do" name="godiste_do" value="<?php echo Input::get('godiste_do'); ?>" min="0" onkeyup="if(value<0) value=0;">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="mileage">Max. Mileage:</label>
                            <input type="number" class="form-control" id="kilometraza_do" name="kilometraza_do" value="<?php echo Input::get('kilometraza_do'); ?>" min="0" onkeyup="if(value<0) value=0;">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="startPrice">Start Price:</label>
                            <input type="number" class="form-control" id="cena_od" name="cena_od" value="<?php echo Input::get('cena_od'); ?>" min="0" onkeyup="if(value<0) value=0;">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="endPrice">End Price:</label>
                            <input type="number" class="form-control" id="cena_do" name="cena_do" value="<?php echo Input::get('cena_do'); ?>" min="0" onkeyup="if(value<0) value=0;">
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="driveType">Drive Type:</label>
                            <select class="form-select" id="pogon" name="pogon">
                                <option value="">None</option>
                                <option value="FWD" <?php if (Input::get('pogon') === 'FWD') echo 'selected'; ?>>Front-Wheel Drive (FWD)</option>
                                <option value="RWD" <?php if (Input::get('pogon') === 'RWD') echo 'selected'; ?>>Rear-Wheel Drive (RWD)</option>
                                <option value="4WD" <?php if (Input::get('pogon') === '4WD') echo 'selected'; ?>>Four-Wheel Drive (4WD)</option>
                                <option value="AWD" <?php if (Input::get('pogon') === 'AWD') echo 'selected'; ?>>All-Wheel Drive (AWD)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="gearBoxType">Gearbox Type:</label>
                            <select class="form-select" id="menjac" name="menjac">
                                <option value="">None</option>
                                <option value="Manual" <?php if (Input::get('menjac') === 'Manual') echo 'selected'; ?>>Manual Transmission</option>
                                <option value="Automatic" <?php if (Input::get('menjac') === 'Automatic') echo 'selected'; ?>>Automatic Transmission</option>
                                <option value="CVT" <?php if (Input::get('menjac') === 'CVT') echo 'selected'; ?>>Continuously Variable Transmission (CVT)</option>
                                <option value="DCT" <?php if (Input::get('menjac') === 'DCT') echo 'selected'; ?>>Dual-Clutch Transmission (DCT)</option>
                                <option value="AMT" <?php if (Input::get('menjac') === 'AMT') echo 'selected'; ?>>Automated Manual Transmission (AMT)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label for="damage">Damage:</label>
                            <select class="form-select" id="damage" name="damage">
                                <option value="">None</option>
                                <option value="none" <?php if (Input::get('damage') === 'none') echo 'selected'; ?>>Not damaged</option>
                                <option value="driveable" <?php if (Input::get('damage') === 'driveable') echo 'selected'; ?>>Damaged (Drvieable)</option>
                                <option value="notdriveable" <?php if (Input::get('damage') === 'notdriveable') echo 'selected'; ?>>Damaged (Not driveable)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row text-center my-2 justify-content-center">
                        <div class="form-group ms-2 ps-4">
                            <button type="submit" class="btn btn-dark">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <form method="POST" action="save-search.php">
                <input type="hidden" name="marka" value="<?php echo Input::get('marka'); ?>" />
                <input type="hidden" name="model" value="<?php echo Input::get('model'); ?>" />
                <input type="hidden" name="godiste_od" value="<?php echo Input::get('godiste_od'); ?>" />
                <input type="hidden" name="godiste_do" value="<?php echo Input::get('godiste_do'); ?>" />
                <input type="hidden" name="kilometraza_do" value="<?php echo Input::get('kilometraza_do'); ?>" />
                <input type="hidden" name="cena_od" value="<?php echo Input::get('cena_od'); ?>" />
                <input type="hidden" name="cena_do" value="<?php echo Input::get('cena_do'); ?>" />
                <input type="hidden" name="pogon" value="<?php echo Input::get('pogon'); ?>" />
                <input type="hidden" name="menjac" value="<?php echo Input::get('menjac'); ?>" />
                <?php
                if(Input::exists('get'))
                 echo '<div class="row text-center my-2 justify-content-center">
                            <div class="form-group ms-2 ps-4">
                                <button type="submit" class="btn btn-dark">Sacuvaj pretragu</button>
                            </div>
                        </div>';
                ?>
            </form>
        </div>
    </div>
    <div class="row my-2"></div>
</div>
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
