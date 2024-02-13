<?php
declare(strict_types=1);
require_once 'service/VestService.php';
require_once 'core/init.php';
if (Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'vestId' => array('required' => true),
        'action' => array('required' => true)
    ));
    if ($validation->passed()) {
        $action = Input::get('action');
        $vest_id = Input::get('vestId');
        if(in_array($action, array('like','dislike'))) {
            if($action === 'like') {
                VestService::getInstance()->likeVest($vest_id);
            } else {
                VestService::getInstance()->dislikeVest($vest_id);
            }
            $vest = VestService::getInstance()->getVestById($vest_id);
            $response = [
                'likes' => $vest->getLajkovi(),
                'dislikes' => $vest->getDislajkovi()
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