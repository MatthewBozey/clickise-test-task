<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adds extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'text',
        'status',
        'url',
        'impressions_count',
        'crm',
        'budget',
        'button_text',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
