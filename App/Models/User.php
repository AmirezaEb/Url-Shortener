<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The User model represents the 'users' table in the database.
 * This model is used to manage user data including name, email, OTP code,
 * and other related information for authentication and identification.
 */
class User extends Model
{
    /**
     * Indicates whether the Eloquent model should manage 'created_at' and 'updated_at' timestamps.
     * Here we disable it because we handle timestamps manually.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Specifies the database table associated with this model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Defines the attributes that are mass assignable.
     * These fields can be filled in bulk during insert or update operations.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',         # User's full name
        'email',        # User's email address (should be unique)
        'otpCode',      # One-time password for authentication
        'otpExpired',   # Timestamp when the OTP expires
        'created_at'    # Timestamp indicating when the user was created
    ];

    /**
     * Defines the relationship between the User model and the Url model.
     * This indicates that each user can have multiple URLs associated with them.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        /**
         * Establishes a has-many relationship with the Url model using 'created_by' as the foreign key.
         * This allows us to access the URLs created by a specific user.
         */
        return $this->hasMany(Url::class, 'created_by');
    }
}
