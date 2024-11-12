<?php

use App\Models\Url;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;


final class UrlTest extends TestCase
{
    /**
     * Set up the database connection before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        # Code to initialize or reset database here (if needed)
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE urls AUTO_INCREMENT = 1');
        parent::tearDown();
    }

    /**
     * Test creating a URL model with valid attributes.
     */
    #[Test]
    public function urlModelCanBeCreatedWithAttributes()
    {
        # Arrange: Create a sample user
        $user = User::create([
            'name' => 'Amirreza',
            'email' => 'aabrahimi1718@example.com',
            'otpCode' => '101010',
            'otpExpired' => (new DateTime())->modify('+10 minutes'),
            'created_at' => new DateTime(),
        ]);

        # Act: Create a URL instance
        $url = Url::create([
            'created_by' => $user->id,
            'url' => 'https://example.com',
            'shortUrl' => 'exmpl',
            'qrCode' => 'path/to/qrcode.png',
            'views' => 0,
            'created_at' => new DateTime(),
        ]);

        # Assert: Check that the attributes were set correctly
        $this->assertEquals($user->id, $url->created_by);
        $this->assertEquals('https://example.com', $url->url);
        $this->assertEquals('exmpl', $url->shortUrl);
        $this->assertEquals('path/to/qrcode.png', $url->qrCode);
        $this->assertEquals(0, $url->views);
    }

    /**
     * Test the relationship between Url and User models.
     */
    #[Test]
    public function urlBelongsToUser()
    {
        # Arrange: Create a user and associate a URL with the user
        $user = User::create(['email' => 'test@example.com', 'password' => 'password']);
        $url = Url::create([
            'created_by' => $user->id,
            'url' => 'https://example.com',
            'shortUrl' => 'exmpl'
        ]);

        # Assert: Check that the user associated with the URL is correct
        $this->assertInstanceOf(User::class, $url->user);
        $this->assertEquals($user->id, $url->user->id);
    }

    /**
     * Test if the URL view count increments correctly.
     */
    #[Test]
    public function urlViewCountIncrementsCorrectly()
    {
        # Arrange: Create a URL model instance with an initial view count
        $url = Url::create([
            'url' => 'https://example.com',
            'created_by' => 1,
            'shortUrl' => 'exmpl',
            'views' => 0
        ]);

        # Act: Increment the views count
        $url->increment('views');
        $url->refresh();

        # Assert: Verify the views count is incremented by 1
        $this->assertEquals(1, $url->views);
    }

    /**
     * Test mass assignment protection for the Url model.
     */
    #[Test]
    public function massAssignmentProtection()
    {
        # Act: Create a URL instance with an extra unfillable attribute
        $url = Url::create([
            'created_by' => 1,
            'url' => 'https://example.com',
            'shortUrl' => 'exmpl',
            'unfillable_attribute' => 'some_value' # This should not be set
        ]);

        # Assert: Check that 'unfillable_attribute' is not assigned
        $this->assertFalse(isset($url->unfillable_attribute));
    }
}
