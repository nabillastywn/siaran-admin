<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'address',
        'phone_number',
        'nim',
        'class',
        'major',
        'study_program',
        'avatar',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function isAdmin()
    {
        return $this->role == 0;
    }

    public function isUserPic()
    {
        return $this->role == 1;
    }

    public function isUserMhs()
    {
        return $this->role == 2;
    }

    public function itemsReports()
    {
        return $this->hasMany(ItemsReport::class, 'user_mhs_id');
    }

    public function bullyingReports()
    {
        return $this->hasMany(BullyingReport::class, 'user_mhs_id');
    }

    public function sarprasReports()
    {
        return $this->hasMany(SaranaReport::class, 'user_mhs_id');
    }

    public function sexualReports()
    {
        return $this->hasMany(SexualReport::class, 'user_mhs_id');
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $roleBasedPath = $this->isUserMhs() ? 'mahasiswa' : 'pic';
                return $value ? asset("/storage/user/{$roleBasedPath}/" . $value) : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100';
            }
        );
    }
}