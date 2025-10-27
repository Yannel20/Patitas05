<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusquedaGuardada extends Model
{
    use HasFactory;

    // 👇 Laravel pensaba que se llamaba "busqueda_guardadas"
    // pero tu tabla es "busquedas_guardadas"
    protected $table = 'busquedas_guardadas';

    protected $fillable = [
        'user_id',
        'termino',
        'filtros',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
