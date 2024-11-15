<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\View;
use App\Models\Url;
use Illuminate\Support\Facades\DB;
use DateTime;

class ViewTest extends TestCase
{
    /**
     * Set up the testing environment before each test.
     * This method is executed before each test method is called.
     * It begins a database transaction to ensure the database remains 
     * consistent during the test and is rolled back after each test.
     */
    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    /**
     * Roll back the transaction after each test to maintain a clean state.
     * This method is executed after each test method is called.
     */
    public function tearDown(): void
    {
        DB::rollBack();
        DB::statement('ALTER TABLE views AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE urls AUTO_INCREMENT = 1');
        parent::tearDown();
    }

    /**
     * Test creating a View record and asserting its attributes.
     * This test ensures that a new View can be created successfully,
     * and its attributes are correctly assigned and accessible.
     */
    #[Test]
    public function itCanCreateView()
    {
        $url = Url::create([
            'created_by' => 1,
            'url' => 'https://example-test.com',
            'shortUrl' => 'exmpl',
            'qrCode' => 'path/to/qrcode.png',
            'views' => 0,
            'created_at' => new DateTime(),
        ]);

        $view = View::create([
            'url_id' => $url->id,
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'created_at' => new DateTime(),
        ]);

        $this->assertEquals($view->url_id, $url->id);
        $this->assertEquals('192.168.1.1', $view->ip_address);
        $this->assertEquals('Mozilla/5.0', $view->user_agent);
    }

    /**
     * Test the relationship between View and Url.
     * This test ensures that a View can correctly retrieve the associated Url 
     * details via the 'url' method.
     */
    #[Test]
    public function ViewBelongsToUrl()
    {
        $url = Url::create([
            'created_by' => 1,
            'url' => 'https://example-test.com',
            'shortUrl' => 'exmple',
            'qrCode' => 'path/to/qrcode.png',
            'views' => 0,
            'created_at' => new DateTime(),
        ]);

        $view = View::create([
            'url_id' => $url->id,
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'created_at' => new DateTime(),
        ]);

        $this->assertEquals($view->url->url, 'https://example-test.com');
        $this->assertEquals($view->url->shortUrl, 'exmple');
        $this->assertEquals($view->url->qrCode, 'path/to/qrcode.png');
    }

    /**
     * Test the creation of a View with an invalid 'url_id'.
     * This test ensures that attempting to create a View with a non-existent URL ID
     * triggers a database exception.
     */
    #[Test]
    public function invalidUrlId()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        View::create([
            'url_id' => 9999,
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'created_at' => new DateTime(),
        ]);
    }

    /**
     * Test the creation of a View with missing required fields.
     * This test ensures that attempting to create a View without essential fields,
     * like 'url_id', results in a database exception.
     */
    public function testCreateViewWithMissingData()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        View::create([
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'created_at' => new DateTime(),
        ]);
    }
}
