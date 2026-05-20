<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendaItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'status',
        'published_at',  // Nieuw veld
        'color',
        'additional_data'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'published_at' => 'datetime',  // Nieuw veld
        'additional_data' => 'array'
    ];

    // Scope voor gepubliceerde items (gebaseerd op published_at)
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    // Scope voor toekomstige items
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    // Accessor voor formatted date
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('d-m-Y H:i');
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date?->format('d-m-Y H:i');
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at?->format('d-m-Y H:i');
    }
}
