<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\App;
class Resume extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'resumes';
    protected $fillable =['name','url','contact','education','summary','skills','experience','deleted_at','user_id'];
    protected $dates = ['deleted_at',];
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function apps(){
        return $this->hasMany(App::class,'resume_id','id');
    }
}
