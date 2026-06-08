<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Vacancy;
class Category extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'categories';
    protected $fillable =['name','deleted_at'];
    protected $dates = ['deleted_at',];
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function vacancies(){
        return $this->hasMany(Vacancy::class,'category_id','id');
    }
}
