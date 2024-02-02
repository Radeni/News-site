<?php
declare(strict_types=1);
require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check(
            $_POST, array(
            'firstname' => array(
                'required' => true,
                'min' => 2,
                'max' => 40,
            ),
            'lastname' => array(
                'required' => true,
                'min' => 2,
                'max' => 40,
            ),
            'email' => array(
                'required' => true,
                'min' => 5,
                'max' => 80,
                'unique' => 'korisnik'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_confirm' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'grad' => array(
                'required' => true,
                'min' => 2,
                'max' => 40,
            ),
            'mobilni' => array(
                'required' => true,
                'min' => 2,
                'max' => 40,
            ),
            )
        );
        
        if ($validation->passed()) {
            $user = new User();

            try {
                $user->create('korisnik', array(
                    'email' => Input::get('email'),
                    'password' => password_hash(Input::get('password'), PASSWORD_BCRYPT),
                    'ime' => Input::get('firstname'),
                    'prezime' => Input::get('lastname'),
                    'mobilni' => Input::get('mobilni'),
                    'grad' => Input::get('grad')
                ));
                Session::flash('home', 'You have been registered and can now log in!');
                Redirect::to('index.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach($validation->errors() as $error) {
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
    <title>Register</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <div class="text-center">
            <h1 class="mt-4">Register</h1>
        </div>
        <form id="registerForm" action="" method="post">
            <div class="input-container">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                <div class="mb-3">
                    <label for="grad" class="form-label">City:</label>
                    <input type="text" class="form-control" id="grad" name="grad" required>
                </div>
                <div class="mb-3">
                    <label for="mobilni" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="mobilni" name="mobilni" required>
                </div>
            </div>
            <div class="text-center">
                 <input type="hidden" value="<?php echo Token::generate(); ?>"  name="token" class="box"/>
                <button type="submit" class="btn btn-dark" >Register</button>
            </div>
        </form>
    </div>
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