<?php
declare(strict_types=1);
require_once 'core/init.php';

$user = new UserManager();
$user->logout();

Redirect::to('index.php');