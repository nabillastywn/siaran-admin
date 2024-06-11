<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
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
     * Sarpras Report
     *
     * @return void
     */
    public function sarprasReport()
    {
        return $this->hasMany(SarprasReport::class);
    }   
}