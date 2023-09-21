<?php

namespace App\Console\Commands;

use App\Models\Cabecera;
use App\Models\Punto;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GenerarFocosCalor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'focos:generar {satelite}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * $satelites
         * string npp
         */
        $satelite = $this->argument("satelite");
        //$path = storage_path('focos');
        
        $carpetaProcesar   = "F:\\PPData\\PPPendientesProcesar\\FocosFIRMS";
        $carpetaProcesados = "F:\\PPData\\PPProcesadosOK\\FocosFIRMS";
        $carpetaError      = "F:\\PPData\\PPProcesadosError\\FocosFIRMS";
        $carpetaLog        = "F:\\PPData\\PPLogs\\EntradasCSV\\FocosFIRMS";

        switch($satelite){
            case "npp":
                /**
                 * chequeo que haya archivos nuevos para SNPP
                 */
                $pattern = "CONAE_PRD_SNPP*";
                $snppCant = glob($carpetaProcesar . "\\" . $pattern);
				if (sizeof($snppCant) > 0){
                    foreach($snppCant as $file){
						$cabeceraOK = $puntoOK = true;

                        $fileName = basename($file);
                        /**
                         * Tengo la cabecera ahora guardo los puntos!
                         */
                        $lineas = File::lines($file)->slice(1);
                        $ultimaHora = "";
                        $ultimaHora = "";
						
                        foreach($lineas as $linea){
                            if ($linea != ""){
                                $punto = new Punto($linea);
                                if ($punto->getHora() != $ultimaHora){
									$ultimaHora = $punto->getHora();
                                    /**
                                     * Si la hora es distinta lo que tengo que hacer es crear una cabecera y comenzar a guardar los puntos con su id
                                     */
                                    /**
                                     * con el nombre del archivo lo parseo y obtengo los datos de la cabecera.
                                     */
                                    list($conae, $tipo, $satelite, $instrumento, $fc, $fecha, $hora, $version, $extra) = explode("_", $fileName);
                                    $cabecera = new Cabecera([
                                        "satelite" => $satelite,
                                        "orbita" => null,
                                        "fechaHoraPasada" => DateTime::createFromFormat("Y-m-d H:i:s", $punto->getFecha() . " " . $punto->getHora() . ":00"),
                                        "fechaHoraCatalogacion" => date('Y-m-d H:i:s'),
                                        "versionsoftware" => $version
                                    ]);
                                    if (!$cabecera->save()){
                                        $cabeceraOK = false;
                                    }
                                }
                                $punto->idCabecera = $cabecera->getIdCabecera();
                                if (!$punto->save()){
                                    $puntoOK = false;
                                }
                            }
                        }
						if ($puntoOK && $cabeceraOK){
                            File::move($carpetaProcesar . "\\" . $fileName, $carpetaProcesados . "\\" . $fileName);
							//Storage::disk($carpetaProcesados . "/" . $fileName)->put($carpetaProcesar . "/" . $fileName, Storage::get($carpetaProcesar . "/" . $fileName));
						}
						else {
							File::move($carpetaProcesar . "\\" . $fileName, $carpetaError . "\\" . $fileName);
							//Storage::disk($carpetaError . "/" . $fileName)->put($carpetaProcesar . "/" . $fileName, Storage::disk($carpetaProcesar)->readStream($carpetaProcesar . "/" . $fileName));
						}
                    }
                }
                $files = File::files($carpetaProcesar);
                var_dump($files);
                die();
                break;
        }
    }
}
