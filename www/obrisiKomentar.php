<?php
declare(strict_types=1);
require_once 'service/KomentarService.php';
require_once 'core/init.php';
$userManager = new UserManager();
if(!$userManager->data()->getTip() === 'glavni_urednik') {
    Redirect::to('index.php');
}
if (Input::exists('get')) {
    $validate = new Validate();
    $validation = $validate->check($_GET, array(
        'komentarId' => array('required' => true),
        'vestId' => array('required' => true)
    ));
    if ($validation->passed()) {
        $komentar_id = Input::get('komentarId');
        KomentarService::getInstance()->deleteKomentar($komentar_id);
        Redirect::to('vest.php?id=' . Input::get('vestId'));
    } else {
        foreach ($validation->errors() as $error) {
            echo $error, '<br>';
        }
    }
}