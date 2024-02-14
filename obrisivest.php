<?php
declare(strict_types=1);

require_once 'core/init.php';
require_once 'service/VestService.php';
require_once 'service/KomentarService.php';
$user = new UserManager();
if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
if(!Input::get('id')) {
    Redirect::to('index.php');
}
$vest_id = Input::get('id');
$vest = VestService::getInstance()->getVestById($vest_id);
if($vest->getIdKorisnik() != $user->data()->getIdKorisnik()) {
    Redirect::to('index.php');
}
KomentarService::getInstance()->deleteAllKomentarsByVestId($vest_id);
VestService::getInstance()->deleteVest($vest_id);

Redirect::to('mojevesti.php');