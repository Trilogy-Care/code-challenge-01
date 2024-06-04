<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillStage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'label', 'color_name', 'order',
    ];

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
