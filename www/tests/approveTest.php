<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../service/VestService.php';
require_once __DIR__ . '/../service/RubrikaService.php';
require_once __DIR__ . '/../core/init.php';

class approveTest extends TestCase
{

    // Test for the approval process
    public function testNewsArticleApproval(): void
    {
        $vest = new Vest(null, 'test', 'test', 'test', date('Y-m-d'), 0, 0, 'DRAFT_PENDING_APPROVAL', 1, 1);
        $vest_id = VestService::getInstance()->createVest($vest);
        // Mock UserManager and its isLoggedIn() and data() methods
        $userManagerMock = $this->createMock(UserManager::class);
        $userManagerMock->method('isLoggedIn')->willReturn(true);
        
        // Mock the data() method to return a user object
        $userMock = $this->createMock(User::class);
        $userMock->method('getTip')->willReturn('glavni_urednik'); // Adjust as needed
        $userManagerMock->method('data')->willReturn($userMock);

        // Mock Input::get() to return a valid vest_id
        //$_GET['id'] = 1;

        // Mock VestService to return a valid vest object for the given vest_id
        $vestServiceMock = $this->createMock(VestService::class);
        // Mock the necessary method(s) to return expected values or objects

        // Mock RubrikaService to return a valid rubrika object
        $rubrikaServiceMock = $this->createMock(RubrikaService::class);
        // Mock the necessary method(s) to return expected values or objects

        // Mock Redirect::to() method to prevent actual redirection
        $redirectMock = $this->createMock(Redirect::class);
        // Expect the Redirect::to() method to be called with the expected URL

        // Execute the approval script
        include '../odobri_vest.php?id=' . $vest_id;
        $vest = VestService::getInstance()->getVestById($vest_id);
        // Assert that the necessary methods or functions are called with the expected parameters
        $this->assertSame('ODOBRENA', $vest->getStatus());
    }
}
?>
