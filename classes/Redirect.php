<?php
declare(strict_types=1);

class Redirect
{
    public static function to($location = null)
    {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include_once 'includes/errors/404.php';
                        break;
                }
            }
            header('Location: ' . $location);
            exit();
        }
    }
}
