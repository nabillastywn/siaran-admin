<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ItemsReport extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
       'lost_items_id', 'user_mhs_id', 'location', 'date', 'name', 'description', 'attachment', 'slug', 'statuses_id'
    ];

    /**
     * lost item
     *
     * @return void
     */
    public function lostItem()
    {
        return $this->belongsTo(LostItem::class);
    }

    /**
     * user mahasiswa
     *
     * @return void
     */
    public function userMhs()
    {
        return $this->belongsTo(UserMhs::class);
    }

    /**
     * status
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * image
     *
     * @return Attribute
     */
    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/report/items/' . $value),
        );
    }

    /**
     * createdAt
     *
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y'),
        );
    }

    /**
     * updatedAt
     *
     * @return Attribute
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y'),
        );
    }
}