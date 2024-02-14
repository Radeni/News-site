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
        $postojeciLajkoviDislajkovi = Session::exists('lajkoviDislajkoviVest') ? Session::get('lajkoviDislajkoviVest') : array();
        
        if (in_array($action, array('like','dislike'))) {
            if ($action === 'like') {
                if (isset($postojeciLajkoviDislajkovi[$vest_id])) {
                    if ($postojeciLajkoviDislajkovi[$vest_id] === 'like') {
                        exit;
                    } elseif ($postojeciLajkoviDislajkovi[$vest_id] === 'dislike') {
                        VestService::getInstance()->unDislikeVest($vest_id);
                        VestService::getInstance()->likeVest($vest_id);
                        $postojeciLajkoviDislajkovi[$vest_id] = 'like';
                    }
                } else {
                    VestService::getInstance()->likeVest($vest_id);
                    $postojeciLajkoviDislajkovi[$vest_id] = 'like';
                }
            } else {
                if (isset($postojeciLajkoviDislajkovi[$vest_id])) {
                    if ($postojeciLajkoviDislajkovi[$vest_id] === 'dislike') {
                        exit;
                    } elseif ($postojeciLajkoviDislajkovi[$vest_id] === 'like') {
                        VestService::getInstance()->DislikeVest($vest_id);
                        VestService::getInstance()->unlikeVest($vest_id);
                        $postojeciLajkoviDislajkovi[$vest_id] = 'dislike';
                    }
                } else {
                    VestService::getInstance()->likeVest($vest_id);
                    $postojeciLajkoviDislajkovi[$vest_id] = 'dislike';
                }
            }
            
            // Update session with updated likes and dislikes
            Session::put('lajkoviDislajkoviVest', $postojeciLajkoviDislajkovi);
            
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
?>
