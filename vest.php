<?php
declare(strict_types=1);
require_once 'service/VestService.php';
require_once 'service/RubrikaService.php';
require_once 'service/KomentarService.php';
require_once 'core/init.php';
if(!Input::get('id'))
{
  Redirect::to('index.php');
}
$vest_id = intval(Input::get('id'));
$vest = VestService::getInstance()->getVestById($vest_id);
$rubrika = RubrikaService::getInstance()->getRubrikaById($vest->getIdRubrika());
$komentari = KomentarService::getInstance()->getAllKomentariByVestId($vest_id);
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="UTF-8">
    <title>Novinari</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .user-card {
            max-width: 18rem;
            margin-bottom: 1rem;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.2);
        }
        .user-card .card-img-top {
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
<div class="container mt-4">
<h1 class="card-title"><?php echo escape($vest->getNaslov())?></h1>
<h3 class="card-title"><?php echo escape($rubrika->getIme())?></h3>
    <?php
    $userManager = new UserManager();
    if($userManager->isLoggedIn()) {
        $user = $userManager->data();
        if($user->getIdKorisnik() === $vest->getIdKorisnik()) {
            echo '<a href="editvest.php?id='.$vest_id.'" class="btn btn-dark">Izmeni Vest</a>';
        }
    }
    ?>
    
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <p class="card-text"><?php echo escape($vest->getDatum()) ?></p>
          <p class="card-text"><?php echo $vest->getTekst() ?></p>
          <p class="card-text"><?php echo $vest->getLajkovi() ?><i class="bi bi-hand-thumbs-up-fill"></i>    <?php echo $vest->getDislajkovi() ?><i class="bi bi-hand-thumbs-down-fill"></i></p>
          <p class="card-text">Tagovi: <?php echo escape($vest->getTagovi()) ?></p>
        </div>
      </div>
    </div>
</div>
<div class="container mt-4">
        <h2>Post Comment</h2>
        <form action="post_comment.php" method="POST">
            <div class="mb-3">
                <label for="commentAuthor" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="commentAuthor" name="commentAuthor" required>
            </div>
            <div class="mb-3">
                <label for="commentText" class="form-label">Comment</label>
                <textarea class="form-control" id="commentText" name="commentText" rows="3" required></textarea>
            </div>
            <input type="hidden" value="<?php echo $vest_id ?>"  name="vestId" class="box"/>
            <input type="hidden" value="<?php echo Token::generate(); ?>"  name="token" class="box"/>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>
<!-- Prikaz komentara -->
<div class="container mt-4">
    


    <h2>Komentari</h2>
    <?php foreach ($komentari as $komentar): ?>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title"><?php echo escape($komentar->getIme()) ?></h5>
                <p class="card-text"><?php echo escape($komentar->getTekst()) ?></p>
                <p class="card-text small"><?php echo $komentar->getLajkovi() ?><i class="bi bi-hand-thumbs-up-fill"></i><?php echo $komentar->getDislajkovi()?><i class="bi bi-hand-thumbs-down-fill"></i></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>


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
