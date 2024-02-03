<?php
declare(strict_types=1);

require_once 'core/init.php';
$user = new User();
$oglas_id = Input::get('id');
$db = DBManager::getInstance();
$oglas = $db->query('SELECT * FROM oglasi WHERE oglas_id = ?', array($oglas_id))->first();
if (!($user->permissionLevel()==2 || ($oglas->korisnik_id == $user->data()->korisnik_id))) {
    Redirect::to('index.php');
}
$slike = $db->get('oglas_ima_sliku', array('oglas_id', '=', $oglas_id))->results();
$db->query("DELETE FROM `oglas_ima_sliku` WHERE `oglas_ima_sliku`.`oglas_id` = ?", array($oglas_id));
foreach ($slike as $slika) {
    $broj_slika = $db->query("SELECT * FROM oglas_ima_sliku WHERE slika_id = ?", array($slika->slika_id))->count();
    if (!($broj_slika > 0)) {
        $db->query("DELETE FROM `slika` WHERE `slika_id` = ?", array($slika->slika_id));
    }
}
$db->query("DELETE FROM `oglasi` WHERE `oglasi`.`oglas_id` = ?", array($oglas_id));

if ($user->permissionLevel() == 2)
    Redirect::to('admin_cars.php');
else 
    Redirect::to('cars_user.php');
