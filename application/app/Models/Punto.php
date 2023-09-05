<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Punto extends Model
{
    use HasFactory, SpatialTrait;

    protected $table = "Puntos";

    protected $fillable = [
        "punto", 
        "brilloT21",
        "scan",
        "track",
        "confianza",
        "brilloT31",
        "power",
        "line",
        "sample"
    ];

    protected $hidden = [
        "idPunto",
        "idCabecera"
    ];

    public function __construct(String $csvLine) {
        list($latitud, $longitud, $fecha, $hora, $this->brilloT21, $this->brilloT31, $this->power, $this->confianza, $this->scan, $this->track) = explode(",", $csvLine);
        $this->punto = new Point();
    }
    public function cabecera (): BelongsTo{
        return $this->belongsTo(Cabecera::class, "idCabecera", "idCabecera");
    }
}
