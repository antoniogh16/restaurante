<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'duration', 'description', 'mode', 'start_date', 
        'finish_date', 'cost', 'image'
    ];

    /**
     * Relación muchos a muchos con Restaurante
     */
    public function restaurantes(): BelongsToMany
    {
        return $this->belongsToMany(Restaurante::class, 'empleados_restaurantes');
    }
}
