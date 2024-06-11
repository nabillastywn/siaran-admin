<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
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
     * campaign
     *
     * @return void
     */
    public function itemsReport()
    {
        return $this->hasMany(ItemsReport::class);
    }
}