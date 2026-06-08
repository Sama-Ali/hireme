<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\App;
use App\Models\Resume;
use App\Models\Company;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasUuids,SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'users';

    protected $fillable = ['name','email','password','role','last_login_at'];

    protected $hidden = ['password','remember_token'];
    
    protected $dates = ['deleted_at',];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function apps(){
        return $this->hasMany(App::class,'user_id','id');
    }

    public function resumes(){
        return $this->hasMany(Resume::class,'user_id','id');
    }

    public function companies(){
        return $this->hasOne(Company::class,'owner_id','id');
    }

}
