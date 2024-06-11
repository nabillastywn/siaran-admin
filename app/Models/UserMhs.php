<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserMhs extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nim',
        'class',
        'major',
        'study_program',
        'phone_number',
        'password',
        'avatar',
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
     * @param $value
    * @return string
    */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    /**
     * items report
     *
     * @return void
     */
    public function itemsReport()
    {
        return $this->hasMany(ItemsReport::class);
    }
    /**
     * bullying report
     *
     * @return void
     */
    public function bullyingReport()
    {
        return $this->hasMany(BullyingReport::class);
    }
    /**
     * sarpras report
     *
     * @return void
     */
    public function sarprasReport()
    {
        return $this->hasMany(SaranaReport::class);
    }
    /**
     * sexual report
     *
     * @return void
     */
    public function sexualReport()
    {
        return $this->hasMany(SexualReport::class);
    }

    /**
     * avatar
     *
     * @return Attribute
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != '' ? asset('/storage/user/mahasiswa/' . $value) : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100',
        );
    }
}