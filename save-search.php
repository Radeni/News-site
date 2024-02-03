<?php
declare(strict_types=1);
require_once 'core/init.php';
$user = new User();
if (!$user->isLoggedIn() || $user->permissionLevel()==2) {
    Redirect::to('index.php');
}
if (Input::exists()) {
    try {
        $db = DBManager::getInstance();
        $db->insert(
            'pretraga', array(
                'marka' => Input::get('marka'),
                'model' => Input::get('model'),
                'godiste_od' => Input::get('godiste_od'),
                'godiste_do' => Input::get('godiste_do'),
                'kilometraza_do' => Input::get('kilometraza_do'),
                'cena_od' => Input::get('cena_od'),
                'cena_do' => Input::get('cena_do'),
                'pogon' => Input::get('pogon'),
                'menjac' => Input::get('menjac'),
                'korisnik_id' => $user->data()->korisnik_id
            )
        );
        
    } catch (Exception $e) {
        die($e->getMessage());
    }
}


$marka = Input::get('marka');
$model = Input::get('model');
$godiste_od = Input::get('godiste_od');
$godiste_do = Input::get('godiste_do');
$kilometraza_do = Input::get('kilometraza_do');
$cena_od = Input::get('cena_od');
$cena_do = Input::get('cena_do');
$pogon = Input::get('pogon');
$menjac = Input::get('menjac');

$searchParams = http_build_query(array(
    'marka' => $marka,
    'model' => $model,
    'godiste_od' => $godiste_od,
    'godiste_do' => $godiste_do,
    'kilometraza_do' => $kilometraza_do,
    'cena_od' => $cena_od,
    'cena_do' => $cena_do,
    'pogon' => $pogon,
    'menjac' => $menjac,
));

$link = 'cars.php?' . $searchParams;

Redirect::to($link);