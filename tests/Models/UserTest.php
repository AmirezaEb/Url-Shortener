<?php

use App\Models\Url;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

final class UserTest extends TestCase
{
    # Database setup before each test
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE urls AUTO_INCREMENT = 1');
        parent::tearDown();
    }

    /**
     * Test if a user can be created and saved in the database.
     */
    #[Test]
    public function itCanCreateAUser()
    {
        $user = new User([
            'name' => 'Amirreza',
            'email' => 'aabrahimi1718@example.com',
            'otpCode' => '101010',
            'otpExpired' => (new DateTime())->modify('+10 minutes'),
            'created_at' => new DateTime(),
        ]);
        $user->save();

        # Assume a find or similar method exists for fetching records
        $savedUser = User::find($user->id);

        $this->assertNotNull($savedUser);
        $this->assertEquals('aabrahimi1718@example.com', $savedUser->email);
        $this->assertEquals('101010', $savedUser->otpCode);
    }

    /**
     * Test if a user can have multiple URLs associated with them.
     */
    #[Test]
    public function userCanHaveMultipleUrls()
    {
        $user = new User([
            'name' => 'Amirreza',
            'email' => 'amirreza@example.com']);

        $user->save();

        $url1 = new Url([
            'created_by' => $user->id,
            'url' => 'https://example.com/1'
        ]);

        $url2 = new Url([
            'created_by' => $user->id,
            'url' => 'https://example.com/2'
        ]);

        $url1->save();
        $url2->save();

        $urls = $user->urls; # Assume urls method retrieves all URLs for this user

        $this->assertCount(2, $urls);
        $this->assertEquals('https://example.com/1', $urls[0]->url);
        $this->assertEquals('https://example.com/2', $urls[1]->url);
    }

    /**
     * Test that the email field in the User model is unique.
     */
    #[Test]
    public function emailMustBeUnique()
    {
        $user1 = new User([
            'name' => 'First User',
            'email' => 'unique@example.com'
        ]);

        $user1->save();

        $user2 = new User([
            'name' => 'Second User',
            'email' => 'unique@example.com'
        ]);

        $this->expectException(\Exception::class);
        $user2->save(); // Assuming save() throws an exception for duplicate emails
    }

    /**
     * Test that the OTP expiration time is set correctly and is in the future.
     */
    #[Test]
    public function otpExpirationIsSetCorrectly()
    {
        $user = new User([
            'name' => 'Amirreza',
            'email' => 'amirreza@example.com',
            'otpCode' => '123456',
            'otpExpired' => (new DateTime())->modify('+5 minutes'),
        ]);
 
        $user->save();

        $this->assertNotNull($user->otpExpired);
        $this->assertGreaterThan(new DateTime(), $user->otpExpired);
    }
}