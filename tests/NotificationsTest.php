<?php

class NotificationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('sierratecnologia:starter')
            ->expectsQuestion('Are you sure you want to overwrite any files of the same name?', true)
            ->expectsQuestion('Would you like to run the migration?', false)
            ->assertExitCode(0);
    }

    public function testBootstrapCommand()
    {
        $this->artisan('sierratecnologia:notifications')
            ->expectsQuestion('Are you sure you want to overwrite any files of the same name?', true)
            ->assertExitCode(0);
    }

    public function testFilesExist()
    {
        $this->assertTrue(file_exists(base_path('app/Http/Controllers/Admin/NotificationController.php')));
        $this->assertTrue(file_exists(base_path('app/Http/Controllers/User/NotificationController.php')));
        $this->assertTrue(file_exists(base_path('app/Services/NotificationService.php')));
    }
}
