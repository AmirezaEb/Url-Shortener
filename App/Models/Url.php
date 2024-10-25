<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    # Disable Eloquent timestamps (created_at and updated_at) as they are not needed
    public $timestamps = false;

    # Specify the database table associated with this model
    protected $table = 'urls';

    # Define the attributes that are mass assignable (for bulk operations like insert/update)
    protected $fillable = [
        'created_by',   // Foreign key, refers to the user who created the URL
        'url',          // The original long URL
        'shortUrl',     // The shortened version of the URL
        'views',        // Number of times the short URL has been accessed
        'created_at'    // Timestamp when the URL was created
    ];

    /**
     * Define the relationship between the Url and User models.
     * Each URL belongs to a single user (one-to-many relationship).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        # This establishes a relationship to the User model based on the 'created_by' foreign key
        return $this->belongsTo(User::class, 'created_by');
    }
}
