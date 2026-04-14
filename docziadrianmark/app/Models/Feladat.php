<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feladat extends Model
{
    use HasFactory;

    protected $table = 'feladatok';

    protected $fillable = [
        'project_id',
        'cim',
        'reszletek',
        'prioritas',
        'kesz_van',
        'hatarido',
    ];

    protected $casts = [
        'hatarido' => 'date',
        'kesz_van' => 'boolean',
    ];

    /**
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
