<?php
declare(strict_types=1);
require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if ($validation->passed()) {
            // Login user
            $userManager = new UserManager();
            $user = $userManager->login(Input::get('username'), Input::get('password'));

            if ($user) {
                Redirect::to('index.php');
            } else {
                echo '<p>Sorry, logging in failed';
            }

        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}
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
          background-color: #ffffff;
        }
    .input-container {
    max-width: 350px;
    margin: 0 auto;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="text-center">
    <h1 class="mt-4">Login</h1>
  </div>
  <form id="loginForm" action="" method="post">
    <div class="input-container">
      <div class="mb-3">
        <label for="text" class="form-label">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
    </div>
    <div class="text-center">
    <input type="hidden" value="<?php echo Token::generate(); ?>"  name="token" class="box"/>
      <button type="submit" class="btn btn-dark" >Login</button>
    </div>
  </form>
</div>


</body>
</html>
