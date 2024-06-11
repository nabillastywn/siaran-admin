<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BullyingReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_mhs_id', 'location', 'date', 'description', 'attachment', 'slug', 'statuses_id'
    ];

    /**
     * Get the user who created the report.
     */
    public function userMhs()
    {
        return $this->belongsTo(UserMhs::class, 'user_mhs_id');
    }

    /**
     * Get the status of the report.
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'statuses_id');
    }

    /**
     * Get the full URL of the attachment.
     *
     * @return Attribute
     */
    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/report/bullying/' . $value),
        );
    }

    /**
     * Format the created_at attribute.
     *
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i'),
        );
    }

    /**
     * Format the updated_at attribute.
     *
     * @return Attribute
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i'),
        );
    }
}