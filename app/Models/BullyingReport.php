<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BullyingReport extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_mhs_id', 'location', 'date', 'description', 'attachment', 'slug', 'statuses_id'
    ];

    public function userMhs()
    {
        return $this->belongsTo(User::class, 'user_mhs_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'statuses_id');
    }

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/report/bullying/' . $value),
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
}