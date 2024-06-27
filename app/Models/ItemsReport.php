<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ItemsReport extends Model
{
    use HasFactory;

    protected $fillable = [
       'lost_item_id', 'user_id', 'location', 'date', 'name', 'description', 'attachment', 'slug', 'status_id'
    ];

    public function lostItem()
    {
        return $this->belongsTo(LostItem::class, 'lost_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/report/items/' . $value),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i'),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i'),
        );
    }
    public function scopeFromMahasiswa($query)
{
    return $query->whereHas('user', function ($query) {
        $query->where('role', User::MAHASISWA_ROLE);
    });
}
}