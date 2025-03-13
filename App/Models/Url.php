<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The Url model represents the 'urls' table in the database.
 * This model handles information about the original URLs, their shortened versions, 
 * and metadata such as the number of views and the generated QR code.
 */
class Url extends Model
{
    /**
     * Indicates whether the Eloquent model should manage 'created_at' and 'updated_at' timestamps.
     * Disabled here because timestamps are handled manually.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Specifies the database table associated with this model.
     *
     * @var string
     */
    protected $table = 'urls';

    /**
     * Defines the attributes that are mass assignable.
     * These fields can be filled in bulk during insert or update operations.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by',   # Foreign key, refers to the user who created the URL entry
        'url',          # The original (long) URL before shortening
        'shortUrl',     # The generated short version of the URL
        'qrCode',       # The file path or URL of the QR code image
        'views',        # The count of how many times the shortened URL has been accessed
        'created_at'    # The timestamp indicating when this URL entry was created
    ];

    /**
     * Defines the relationship between the Url and User models.
     * This indicates that each URL entry is created by a specific user.
     * Sets up a 'belongsTo' relationship where each URL belongs to one user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        /**
         * Establishes a belongs-to relationship with the User model using 'created_by' as the foreign key.
         * Allows access to user details who created this URL.
         */
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Defines the relationship between the Url and View models.
     * This indicates that each URL can have multiple views (one-to-many relationship).
     * Sets up a 'hasMany' relationship where one URL has many view records.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views()
    {
        /**
         * Establishes a has-many relationship with the View model using 'url_id' as the foreign key.
         * Allows retrieval of all view entries associated with this specific URL.
         */
        return $this->hasMany(View::class, 'url_id');
    }
}
