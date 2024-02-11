<?php
declare(strict_types=1);

require_once 'core/init.php';
require_once 'service/UserRubrikaService.php';
$user = new UserManager();
$beaner_id = Input::get('id');
$db = DBManager::getInstance();
if ($user->data()->getTip() != 'glavni_urednik')
{
    Redirect::to('index.php');
}
UserRubrikaService::getInstance()->purgeUser($beaner_id);

UserService::getInstance()->deleteUser($beaner_id);



Redirect::to('user_management.php');