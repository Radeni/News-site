<?php
declare(strict_types=1);

require_once 'core/init.php';
require_once 'service/VestService.php';
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
$vest->setStatus("DRAFT_PENDING_APPROVAL");
VestService::getInstance()->updateVest($vest);

Redirect::to('editvest.php?id=' . $vest_id);