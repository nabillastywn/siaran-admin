<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SaranaReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'sarpras_id', 'user_id', 'location', 'date', 'report', 'attachment', 'slug', 'status_id'
    ];

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class, 'sarpras_id');
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
            get: fn ($value) => asset('/storage/report/sarpras/' . $value),
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