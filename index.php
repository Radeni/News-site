<?php
declare(strict_types=1);
require_once 'service/VestService.php';
require_once 'core/init.php';
$db = DBManager::getInstance();

// Pagination variables
$articlesPerPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $articlesPerPage;

// Fetch total number of articles
$totalArticles = VestService::getInstance()->countAll();
$totalPages = ceil($totalArticles / $articlesPerPage);

// Fetch news articles for the current page
$articles = VestService::getInstance()->getArticlesByPage($page, $articlesPerPage);

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
<style>
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
<div class="container mt-3">
  <ul class="category-list">
    <li><a href="category.php?id=all" class="category-link active">All Categories</a></li>
    <li><a href="category.php?id=1" class="category-link">Category 1</a></li>
    <li><a href="category.php?id=2" class="category-link">Category 2</a></li>
    <li><a href="category.php?id=3" class="category-link">Category 3</a></li>
    <!-- Add more categories as needed -->
  </ul>
</div>

<!-- Space between categories and articles -->
<div class="container mt-3">

</div>

<!-- Articles Section -->
<div class="container">
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($articles as $article): ?>
      <?php if ($article->getStatus() === 'draft'): ?>
        <div class="col mb-3">
          <div class="card h-100 article">
            <div class="card-body">
              <h1 class="card-title"><?php echo $article->getNaslov(); ?></h1>
              <p class="card-text"><?php echo substr($article->getTekst(), 0, 150) . '...'; ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <i class="fas fa-thumbs-up"></i> <?php echo $article->getLajkovi(); ?>
                  <i class="fas fa-thumbs-down"></i> <?php echo $article->getDislajkovi(); ?>
                </div>
                <a href="vest.php?id=<?php echo $article->getIdVest(); ?>" class="btn btn-primary">Read More</a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>

<!-- Pagination -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($page === $i) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&per_page=<?php echo $articlesPerPage; ?>"><?php echo $i; ?></a></li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<!-- Dropdown menu for selecting number of articles per page -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form action="" method="GET" class="form-inline">
        <label for="per_page">Articles Per Page:</label>
        <select name="per_page" id="per_page" class="form-control ml-2" onchange="this.form.submit()">
          <option value="5" <?php echo ($articlesPerPage == 5) ? 'selected' : ''; ?>>5</option>
          <option value="10" <?php echo ($articlesPerPage == 10) ? 'selected' : ''; ?>>10</option>
          <option value="20" <?php echo ($articlesPerPage == 20) ? 'selected' : ''; ?>>20</option>
        </select>
      </form>
    </div>
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