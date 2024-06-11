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
       'sarpras_id', 'user_mhs_id', 'location', 'date', 'report', 'attachment', 'slug'
    ];

    public function sarpras()
    {
        return $this->belongsTo(Sarpras::class);
    }

    public function userMhs()
    {
        return $this->belongsTo(UserMhs::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
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
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y'),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y'),
        );
    }
}