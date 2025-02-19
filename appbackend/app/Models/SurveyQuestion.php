<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestion extends Model
{
    protected $fillable = [
        'section_id',
        'text',
        'type',
        'order',
        'required'
    ];

    /**
     * Get the section that owns the question.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(SurveySection::class);
    }

    /**
     * Get the options for this question.
     */
    public function options(): HasMany
    {
        return $this->hasMany(SurveyQuestionOption::class, 'question_id')
                    ->orderBy('order');
    }

    /**
     * Get the responses for this question.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class, 'question_id');
    }

    /**
     * Scope a query to include options for select and radio questions.
     */
    public function scopeWithOptions($query)
    {
        return $query->with(['options' => function($q) {
            $q->orderBy('order');
        }]);
    }
}
