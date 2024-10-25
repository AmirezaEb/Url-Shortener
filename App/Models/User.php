<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    # Disable Eloquent timestamps (created_at and updated_at) since they are not being used
    public $timestamps = false;

    # Specify the database table associated with this model
    protected $table = 'users';

    // Define the attributes that are mass assignable (for bulk operations like insert/update)
    protected $fillable = [
        'name',         # User's full name
        'email',        # User's email address (should be unique)
        'otpCode',      # One-time password for authentication
        'otpExpired',   # Timestamp when the OTP expires
        'created_at'    # Timestamp when the user record was created
    ];

    /**
     * Define the relationship between the User and Url models.
     * Each user can have multiple URLs associated with them (one-to-many relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        # This establishes a relationship to the Url model based on the 'created_by' foreign key
        return $this->hasMany(Url::class, 'created_by');
    }
}

?>