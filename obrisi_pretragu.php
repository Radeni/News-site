<?php
declare(strict_types=1);

require_once 'core/init.php';
$user = new User();
if ($user->permissionLevel()!=1) {
    Redirect::to('index.php');
}
$db = DBManager::getInstance();
$db->query("DELETE FROM `pretraga` WHERE `pretraga`.`pretraga_id` = ?", array(Input::get('id')));
Redirect::to('searches.php');