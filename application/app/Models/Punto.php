<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Support\Facades\DB;

class Punto extends Model
{
    use HasFactory, HasPostgisColumns;

    protected $table = "Puntos";
    protected $primaryKey = 'idPunto';
    public $timestamps = false;

    protected $fillable = [
        "brilloT21",
        "punto",
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

    protected array $postgisColumns = [
        'punto' => [
            'type' => 'point',
            'srid' => 4326,
        ],
    ];

    private $hora, $fecha;

    public function __construct(string $csvLine) {
        list($longitud, $latitud, $this->fecha, $this->hora, $this->brilloT21, $this->brilloT31, $this->power, $this->confianza, $this->scan, $this->track) = explode(",", $csvLine);
        //$this->punto = "ST_GeomFromText('SRID=4326;POINT(".$latitud." ".$longitud.")')";
        //$this->punto = Point::make($latitud, $longitud, null, null, 4326);
        $this->punto = DB::raw("ST_GeomFromText('SRID=4326;POINT(".$latitud." ".$longitud.")')");
    }

    public function cabecera (): BelongsTo{
        return $this->belongsTo(Cabecera::class, "idCabecera", "idCabecera");
    }

    public function getHora (){
        return $this->hora;
    }

    public function getFecha (){
        return $this->fecha;
    }
}
