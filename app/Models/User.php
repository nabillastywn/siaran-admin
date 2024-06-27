<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
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

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    const ADMIN_ROLE = 0;
    public function isAdmin()
    {
        return $this->role == self::ADMIN_ROLE;
    }

    const PIC_ROLE = 1;
    public function isUserPic()
    {
        return $this->role == self::PIC_ROLE;
    }

    const MAHASISWA_ROLE = 2;
    public function isUserMhs()
    {
        return $this->role == self::MAHASISWA_ROLE;
    }

    public function itemsReports()
    {
        return $this->hasMany(ItemsReport::class, 'user_id');
    }

    public function bullyingReports()
    {
        return $this->hasMany(BullyingReport::class, 'user_id');
    }

    public function sarprasReports()
    {
        return $this->hasMany(SaranaReport::class, 'user_id');
    }

    public function sexualReports()
    {
        return $this->hasMany(SexualReport::class, 'user_id');
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // Check if the stored value is already a full URL
                if (strpos($value, 'http://') === 0 || strpos($value, 'https://') === 0) {
                    return $value;
                }
    
                // Otherwise, return the full URL
                return $value ? asset("/storage/user/" . $value) : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100';
            }
        );
    }
    

// protected function avatar(): Attribute
//     {
//         return Attribute::make(
//             get: fn ($value) => $value != '' ? asset("/storage/user/" . $value) : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100',
//         );
//     }


// protected function avatar(): Attribute
//     {
//         return Attribute::make(
//             get: function ($value) {
//                 $roleBasedPath = $this->isUserMhs() ? 'mahasiswa' : 'pic';
//                 return $value ? asset("/storage/user/" . $value) : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100';
//             }
//         );
//     }
}