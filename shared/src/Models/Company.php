<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\Vacancy; // add this line

class Company extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'companies';
    protected $fillable =['name','location','industry','website','deleted_at','owner_id'];
    protected $dates = ['deleted_at',];
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function owner(){
        return $this->belongsTo(User::class,'owner_id','id');
    }

    public function vacancies(){
        return $this->hasMany(Vacancy::class,'company_id','id');
    }
}
