<?php
declare(strict_types=1);

require_once 'core/init.php';
require_once 'service/UserRubrikaService.php';
require_once 'service/VestService.php';
require_once 'service/UserService.php';
require_once 'data/Vest.php';
$user = new UserManager();
if ($user->data()->getTip() != 'glavni_urednik')
{
    Redirect::to('index.php');
}
if(!Input::get('id')) {
    Redirect::to('index.php');
}
$beaner_id = Input::get('id');
UserRubrikaService::getInstance()->purgeUser($beaner_id);
$vesti = VestService::getInstance()->getAllFromKorisnik($beaner_id);
foreach($vesti as $vest) {
    $vest->setKorisnik($user->data()->getIdKorisnik());
    VestService::getInstance()->updateVest($vest);
}
UserService::getInstance()->deleteUser($beaner_id);

Redirect::to('user_management.php');