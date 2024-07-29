<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bill_reference', 'bill_date', 'submitted_at', 'approved_at', 'on_hold_at', 'bill_stage_id',
    ];

    protected $casts = [
        'bill_date' => 'datetime',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'on_hold_at' => 'datetime',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
