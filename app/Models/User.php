<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relasi berdasarkan role.
     *
     * @return bool
     */
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

    /**
     * items report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemsReport()
    {
        return $this->hasMany(ItemsReport::class);
    }

    /**
     * bullying report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bullyingReport()
    {
        return $this->hasMany(BullyingReport::class);
    }

    /**
     * sarpras report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sarprasReport()
    {
        return $this->hasMany(SaranaReport::class);
    }

    /**
     * sexual report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sexualReport()
    {
        return $this->hasMany(SexualReport::class);
    }

    /**
     * avatar
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
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