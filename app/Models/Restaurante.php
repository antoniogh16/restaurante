<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurante extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'last_name', 'country_id'];

    /**
     * Relación muchos a muchos con Empleado
     */
    public function empleados(): BelongsToMany
    {
        return $this->belongsToMany(Empleado::class, 'empleados_restaurantes');
    }

    /**
     * Relación con Country
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
