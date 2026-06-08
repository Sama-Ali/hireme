<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\Resume;
use App\Models\Vacancy;
class App extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'apps';
    protected $fillable =['status','ai_score','ai_feedback','deleted_at','user_id','resume_id','vacancy_id'];
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

    public function resume(){
        return $this->belongsTo(Resume::class,'resume_id','id');
    }

    public function vacancy(){
        return $this->belongsTo(Vacancy::class,'vacancy_id','id');
    }
}
