<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    
    public $timestamps = false;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'otpCode',
        'otpExpired',
        'created_at'
    ];

    public function urls()
    {
        return $this->hasMany(Url::class,'created_by');
    }
}

?>

