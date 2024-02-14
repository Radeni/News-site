<?php
declare(strict_types=1);
require_once 'service/VestService.php';
require_once 'service/UserRubrikaService.php';
require_once 'core/init.php';

$currentKorisnik = new UserManager();
if ($currentKorisnik->data() === null) {
  Redirect::to('index.php');
}
$korisnik_id = $currentKorisnik->data()->getIdKorisnik();
$articles = array();
if($currentKorisnik->data()->getTip() == 'urednik')
{
  $rubrike = UserRubrikaService::getInstance()->getUserRubrikas($korisnik_id);
  foreach ($rubrike as $rubrika) {

    $rubrika_id = $rubrika->getIdRubrika();
    $currentArray = VestService::getInstance()->getAllPendingFromRubrika($rubrika_id);
    $articles = array_merge($articles, $currentArray);
  }
} elseif($currentKorisnik->data()->getTip() == 'glavni_urednik') {
  $articles = VestService::getInstance()->getAllPending();
} else {
  Redirect::to('index.php');
}

require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org" xmlns:sec="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <!-- Include FontAwesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Custom CSS -->
  <style>
    /* Custom CSS */
  /* Your CSS styles here */
  .category-list {
    list-style: none;
    padding: 0;
  }

  .category-list li {
    display: inline-block;
    margin-right: 10px;
  }

  .category-link {
    color: #444; /* Dark grey color */
    text-decoration: none; /* Remove underline */
    transition: color 0.3s; /* Smooth color transition */
  }

  .category-link:hover {
    color: #888; /* Light grey color */
  }

  .category-link.active {
    font-weight: bold;
  }
</style>
</head>
<body>

<!-- Your navigation bar -->
<!-- Include Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include FontAwesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
  // Your JavaScript code here
</script>
</body>
</html>

<!-- Categories Section -->


<!-- Space between categories and articles -->
<div class="container mt-3">
<h1>Vesti na cekanju:</h1>
</div>

<!-- Articles Section -->
<div class="container">
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($articles as $article): ?>
        <div class="col mb-3">
          <div class="card h-100 article">
            <div class="card-body">
              <h1 class="card-title"><?php echo $article->getNaslov(); ?></h1>
              <p class="card-text"><?php echo substr($article->getTekst(), 0, 150) . '...'; ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <a href="vest.php?id=<?php echo $article->getIdVest(); ?>" class="btn btn-primary">Pregledaj</a>
                <?php
                if($article->getStatus() == 'DRAFT_PENDING_APPROVAL') {
                  echo '<a href="odobri_vest.php?id='.$article->getIdVest().'" class="btn btn-danger">Odobri vest</a>';
                }
                elseif($article->getStatus() == 'DRAFT_PENDING_CHANGE') {
                  echo '<a href="odobri_vest.php?id='.$article->getIdVest().'" class="btn btn-danger">Odobri izmenu</a>';
                }
                elseif($article->getStatus() == 'PENDING_DELETION') {
                  echo '<a href="obrisi_vest_po_zahtevu.php?id='.$article->getIdVest().'" class="btn btn-danger">Odobri brisanje</a>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
    <?php endforeach; ?>
  </div>
</div>


<!-- Include Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include FontAwesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
  // Your JavaScript code here
</script>
</body>
</html>