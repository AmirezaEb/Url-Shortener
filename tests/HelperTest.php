<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class HelperTest extends TestCase
{

    /**
     * Test siteUrl function to ensure it generates the correct full URL.
     * Verifies that the function appends the given path to the APP_HOST environment variable.
     */

    #[Test]
    public function getSiteUrl()
    {
        $_ENV['APP_HOST'] = 'http://localhost';
        $this->assertEquals('http://localhost/test', siteUrl('test')); # Test with path
        $this->assertEquals('http://localhost/', siteUrl(''));         # Test with empty path
    }

    /**
     * Test assetUrl function to confirm it generates a correct asset URL.
     * Checks if the function appends the given asset path to the APP_HOST environment variable.
     */

    #[Test]
    public function getAssetUrl()
    {
        $_ENV['APP_HOST'] = 'http://localhost';
        $this->assertEquals('http://localhost/resources/assets/css/en/style.css', assetUrl('css/en/style.css'));
    }

    /**
     * Test alarm function to ensure it generates a correct JavaScript alert.
     * Checks if the generated script contains required Swal.fire and title.
     */

    #[Test]
    public function getAlarm()
    {
        $script = alarm('success', 'Test message', '300px', 'top-end');
        $this->assertStringContainsString('Swal.fire', $script);              # Verify Swal.fire usage
        $this->assertStringContainsString("title: 'Test message'", $script);  # Verify message content
    }

    /**
     * Test shortCreate function to ensure it generates a string of correct length.
     * Confirms that the result is a string with a length between 3 and 10 characters.
     */

    #[Test]
    public function getShortCreate()
    {
        $short = shortCreate();
        $this->assertIsString($short);               # Check if result is a string
        $this->assertGreaterThanOrEqual(3, strlen($short)); # Minimum length check
        $this->assertLessThanOrEqual(10, strlen($short));   # Maximum length check
    }

    /**
     * Test getNow function to verify it generates the current URL.
     * Mocks the HTTP_HOST and REQUEST_URI server variables and checks if the URL is correct.
     */

    #[Test]
    public function getNow()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/test';
        $this->assertEquals('http://localhost/test', getNow());
    }

    /**
     * Test to check if a view file exists.
     * Temporarily creates a view file, calls the view function, and removes the file.
     * No assertions needed, but it ensures no exceptions are thrown during the process.
     */
    
    #[Test]
    public function isViewFileExists()
    {
        $this->expectNotToPerformAssertions();

        $viewPath = BASEPATH . 'resources/views/home/testView.php';
        file_put_contents($viewPath, ''); # Create temporary view file

        view('home.testView'); # Call view function
        unlink($viewPath);     # Remove temporary file
    }
}
