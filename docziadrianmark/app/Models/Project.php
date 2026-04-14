<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'felhasznalo_id',
        'nev',
        'leiras',
        'allapot',
        'hatarido',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'felhasznalo_id');
    }

    /**
     * Get the tasks (feladatok) for the project.
     */
    public function feladatok(): HasMany
    {
        return $this->hasMany(Feladat::class, 'project_id');
    }
}
