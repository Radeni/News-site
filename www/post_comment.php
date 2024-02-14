<?php
declare(strict_types=1);
require_once 'service/KomentarService.php';
require_once 'data/Komentar.php';
require_once 'core/init.php';
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'commentAuthor' => array('required' => true, 'max' => 45),
            'commentText' => array('required' => true, 'max' => 300)
        ));

        if ($validation->passed()) {
            $komentar = new Komentar(null, Input::get('commentAuthor'), Input::get('commentText'), 0, 0, Input::get('vestId'));
            KomentarService::getInstance()->createKomentar($komentar);
            Redirect::to('vest.php?id=' . Input::get('vestId'));

        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}