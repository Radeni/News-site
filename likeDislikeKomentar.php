<?php
declare(strict_types=1);
require_once 'service/KomentarService.php';
require_once 'core/init.php';
if (Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'commentId' => array('required' => true),
        'action' => array('required' => true)
    ));
    if ($validation->passed()) {
        $action = Input::get('action');
        $komentar_id = Input::get('commentId');
        $postojeciLajkoviDislajkovi = Session::exists('lajkoviDislajkoviKomentari') ? Session::get('lajkoviDislajkoviKomentari') : array();
        
        if (in_array($action, array('like','dislike'))) {
            if ($action === 'like') {
                if (isset($postojeciLajkoviDislajkovi[$komentar_id])) {
                    if ($postojeciLajkoviDislajkovi[$komentar_id] === 'like') {
                        exit;
                    } elseif ($postojeciLajkoviDislajkovi[$komentar_id] === 'dislike') {
                        KomentarService::getInstance()->unDislikeKomentar($komentar_id);
                        KomentarService::getInstance()->likeKomentar($komentar_id);
                        $postojeciLajkoviDislajkovi[$komentar_id] = 'like';
                    }
                } else {
                    KomentarService::getInstance()->likeKomentar($komentar_id);
                    $postojeciLajkoviDislajkovi[$komentar_id] = 'like';
                }
            } else {
                if (isset($postojeciLajkoviDislajkovi[$komentar_id])) {
                    if ($postojeciLajkoviDislajkovi[$komentar_id] === 'dislike') {
                        exit;
                    } elseif ($postojeciLajkoviDislajkovi[$komentar_id] === 'like') {
                        KomentarService::getInstance()->DislikeKomentar($komentar_id);
                        KomentarService::getInstance()->unlikeKomentar($komentar_id);
                        $postojeciLajkoviDislajkovi[$komentar_id] = 'dislike';
                    }
                } else {
                    KomentarService::getInstance()->likeKomentar($komentar_id);
                    $postojeciLajkoviDislajkovi[$komentar_id] = 'dislike';
                }
            }
            
            // Update session with updated likes and dislikes
            Session::put('lajkoviDislajkoviKomentari', $postojeciLajkoviDislajkovi);
            
            $komentar = KomentarService::getInstance()->getKomentarById($komentar_id);
            $response = [
                'likes' => $komentar->getLajkovi(),
                'dislikes' => $komentar->getDislajkovi()
            ];
            
            // Set the appropriate content type header
            header('Content-Type: application/json');
            
            // Return the response as JSON
            echo json_encode($response);
            exit; // Stop further execution
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo $error, '<br>';
        }
    }
}
?>
