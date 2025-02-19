<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveySection extends Model
{
    protected $fillable = [
        'title',
        'order'
    ];

    /**
     * Get the questions for this section.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class, 'section_id')
                    ->orderBy('order');
    }
}
