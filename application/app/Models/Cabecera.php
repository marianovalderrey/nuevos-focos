<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabecera extends Model
{
    use HasFactory;

    protected $table = "Cabeceras";
    protected $primaryKey = 'idCabecera';
    public $timestamps = false;

    protected $fillable = [
        "satelite",
        "orbita",
        "fechaHoraPasada",
        "fechaHoraCatalogacion",
        "versionsoftware"
    ];

    protected $hidden = [
        "idCabecera"
    ];

    protected $casts = [
        "fechaHoraPasada" => "datetime",
        "fechaHoraCatalogacion" => "datetime"
    ];

    public function puntos (): HasMany {
        return $this->hasMany(Punto::class, "idCabecera", "idCabecera");
    }
}
