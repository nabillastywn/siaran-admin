<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];
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
}