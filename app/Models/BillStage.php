<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;

class BillStage extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DRAFT = 'Draft';
    const SUBMITTED = 'Submitted';
    const APPROVED = 'Approved';
    const PAYING = 'Paying';
    const ON_HOLD = 'On Hold';
    const REJECTED = 'Rejected';
    const PAID = 'Paid';

    protected $fillable = [
        'name', 'label', 'color_name', 'order',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeByLabel(Builder $builder, string $label): Builder
    {
        return $builder->where('label', $label);
    }

}