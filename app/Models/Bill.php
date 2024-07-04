<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STAGES = [
        'DRAFT' => 1,
        'SUBMITTED' => 2,
        'APPROVED' => 3,
        'PAYING' => 4,
        'ON_HOLD' => 5,
        'REJECTED' => 6,
        'PAID' => 7,
    ];
    
    protected $fillable = [
        'bill_reference', 'bill_date', 'submitted_at', 'approved_at', 'on_hold_at', 'bill_stage_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(BillStage::class);
    }

    public function scopeWithStage($q, $bill_stage_id)
    {
        return $q->where('bill_stage_id', $bill_stage_id);
    }
}