<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;
use App\Models\Category;
use App\Models\App;
class Vacancy extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'vacancies';
    protected $fillable = ['title','description','location','salary','type','deleted_at','company_id','category_id','views'];    
    protected $dates = ['deleted_at',];
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }
    
    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function apps(){
        return $this->hasMany(App::class,'vacancy_id','id');
    }

}
