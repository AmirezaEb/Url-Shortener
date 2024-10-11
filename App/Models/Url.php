<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model{
    
    public $timestamps = false;
    protected $table = 'urls';
    protected $fillable = [
        'created_by',
        'url',
        'shortUrl',
        'views',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
?>