<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The View model represents the 'views' table in the database.
 * This model is used to store information about individual views/visits of URLs,
 * including the URL ID, IP address, and timestamp of the visit.
 */
class View extends Model
{
    /**
     * Indicates whether the Eloquent model should manage 'created_at' and 'updated_at' timestamps.
     * Here we disable it because we are handling timestamps manually.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Specifies the database table associated with this model.
     *
     * @var string
     */
    protected $table = 'views';

    /**
     * Defines the attributes that are mass assignable.
     * These fields can be filled in bulk during insert or update operations.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url_id',       # Foreign key referencing the 'urls' table
        'ip_address',   # Stores the IP address of the visitor
        'user_agent',   # Stores the user agent  of the visitor
        'created_at'    # Timestamp indicating when the view occurred
    ];

    /**
     * Defines the relationship between the View model and the Url model.
     * This indicates that each View entry is associated with a specific URL.
     * It sets up a 'belongsTo' relationship where a view belongs to one URL (many-to-one).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        /**
         * Establishes a belongs-to relationship with the Url model using 'url_id' as the foreign key.
         * This allows us to access the associated URL details for a given view instance.
         */
        return $this->belongsTo(Url::class, 'url_id');
    }
}
