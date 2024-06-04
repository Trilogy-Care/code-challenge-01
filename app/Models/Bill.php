<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bill_reference', 'bill_date', 'submitted_at', 'approved_at', 'on_hold_at', 'bill_stage_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(BillStage::class, 'bill_stage_id');
    }

    public function scopeByStageLabel(Builder $query, string $label): void
    {
        $query->whereHas('stage', function ($query) use ($label) {
            $query->where('label', str($label)->title());
        });
    }
}
