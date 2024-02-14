<?php
declare(strict_types=1);
require_once 'service/RubrikaService.php';
require_once 'data/User.php';
require_once 'service/UserRubrikaService.php';
require_once 'core/init.php';

$userManager = new UserManager();
if(!$userManager->isLoggedIn() || $userManager->data()->getTip() != 'glavni_urednik')
{
  Redirect::to('index.php');
}
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check(
            $_POST, array(
            'firstname' => array(
                'required' => true,
                'min' => 2,
                'max' => 45,
            ),
            'lastname' => array(
                'required' => true,
                'min' => 2,
                'max' => 45,
            ),
            'username' => array(
                'required' => true,
                'min' => 5,
                'max' => 80,
                'uniqueUserUsername' => 'HMMMMMMMMMM'
            ),
            'password' => array(
                'required' => true,
                'min' => 3
            ),
            'password_confirm' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'telefon' => array(
                'required' => true,
                'min' => 5,
                'max' => 12,
            ),
            'tip' => array(
                'required' => true
            ),
            )
        );
        
        if ($validation->passed()) {

            try {
                $user = new User(null, Input::get('username'), Input::get('password'), Input::get('firstname'), Input::get('lastname'), Input::get('telefon'), Input::get('tip'));
                $user_id = UserService::getInstance()->registerUser($user);
                foreach (Input::get('rubrike') as $rubrika) {
                    UserRubrikaService::getInstance()->addUserToRubrika($user_id,$rubrika);
                }
                if($user_id) {
                    Redirect::to('manage_user.php?id=' . $user_id);
                }
                else {
                    die();
                }
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
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
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
                    <label for="telefon" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="telefon" name="telefon" required>
                </div>
                <div class="mb-3">
                <label for="tip" class="form-label">Tip:</label>
                <select class="form-select" id="tip" name="tip" required>
                    <option value="novinar">Novinar</option>
                    <option value="urednik">Urednik</option>
                </select>
                </div>
                <div class="mb-3">
                <label for="tip" class="form-label">Rubrike:</label>
                <?php
                    $rubrike = RubrikaService::getInstance()->getAllRubrikas();
                    if(count($rubrike) > 0) {
                        foreach($rubrike as $rubrika) {
                            echo    '<div>';
                            echo    '   <input type="checkbox" id="'. $rubrika->getIdRubrika() . '" name="rubrike[]" value="'. $rubrika->getIdRubrika() . '">';
                            echo    '   <label for="'. $rubrika->getIdRubrika() . '">'. $rubrika->getIme() . '</label>';
                            echo    '</div>';
                        }
                    }
                    else {
                        echo    '<div>';
                        echo    'NE POSTOJI NI JEDNA RUBRIKA!!!!!!!!!!';
                        echo    '</div>';
                    }
                ?>
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