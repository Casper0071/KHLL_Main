<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'published_at',
        'color',
        'image',  // Nieuw veld
        'additional_data'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'published_at' => 'datetime',
        'additional_data' => 'array'
    ];

    // Delete image when model is deleted
    protected static function booted()
    {
        static::deleting(function ($agendaItem) {
            if ($agendaItem->image && Storage::disk('public')->exists($agendaItem->image)) {
                Storage::disk('public')->delete($agendaItem->image);
            }
        });

        // Also delete image when force deleted
        static::forceDeleted(function ($agendaItem) {
            if ($agendaItem->image && Storage::disk('public')->exists($agendaItem->image)) {
                Storage::disk('public')->delete($agendaItem->image);
            }
        });
    }

    // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // Haal alleen de bestandsnaam op als het pad te lang is
        $filename = basename($this->image);

        // Controleer of het bestand bestaat in de storage map
        $fullPath = storage_path('app/public/agenda-images/' . $filename);

        if (file_exists($fullPath)) {
            return asset('storage/agenda-images/' . $filename);
        }

        // Fallback naar de opgeslagen path
        return asset('storage/' . $this->image);
    }

    // Scope voor gepubliceerde items
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
