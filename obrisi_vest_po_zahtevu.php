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
if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
if($user->data()->getTip()=='glavni_urednik') {
    KomentarService::getInstance()->deleteAllKomentarsByVestId($vest_id);
    VestService::getInstance()->deleteVest($vest_id);
}
if($user->data()->getTip()=='urednik') {
    $rubrike = UserRubrikaService::getInstance()->getUserRubrikas($user->data()->getIdKorisnik());
    if(!$rubrike) {
        Redirect::to('index.php');
    }
    $rubrika_vest = RubrikaService::getInstance()->getRubrikaById($vest->getIdRubrika());
    if(in_array($rubrika_vest, $rubrike)) {
        KomentarService::getInstance()->deleteAllKomentarsByVestId($vest_id);
        VestService::getInstance()->deleteVest($vest_id);
    }
}
Redirect::to('editor_news.php');
