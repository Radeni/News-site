<?php
declare(strict_types=1);
require_once 'core/init.php';
require_once 'service/UserService.php';
require_once 'service/UserRubrikaService.php';
require_once 'service/RubrikaService.php';
require_once 'service/VestService.php';
$userManager = new UserManager();
if(!$userManager->isLoggedIn() && $userManager->data()->getTip() != 'glavni_urednik' && $userManager->data()->getTip() != 'urednik') {
    Redirect::to('index.php');
}
$vest_id = Input::get('id');
if($vest_id == null) {
    Redirect::to('index.php');
}
$vest = VestService::getInstance()->getVestById($vest_id);
$rubrike = UserRubrikaService::getInstance()->getUserRubrikas($userManager->data()->getIdKorisnik());
$vest_rubrika = RubrikaService::getInstance()->getRubrikaById($vest->getIdRubrika());
if($userManager->data()->getTip() === 'urednik' && !$rubrike) {
    Redirect::to('index.php');
}
if($userManager->data()->getTip() === 'urednik' && !in_array($vest_rubrika, $rubrike)) {
    Redirect::to('index.php');
}
if($vest->getStatus() == 'DRAFT_PENDING_APPROVAL') {
    $vest->setDatum(date('Y-m-d'));
}
$vest->setStatus('ODOBRENA');
VestService::getInstance()->updateVest($vest);
Redirect::to('editor_news.php');