<?php

namespace App\Console\Commands;

use App\Models\Cabecera;
use App\Models\Punto;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        $path = storage_path('focos');
        
        switch($satelite){
            case "npp":
                /**
                 * chequeo que haya archivos nuevos para SNPP
                 */
                $pattern = "CONAE_PRD_SNPP*";
                $snppCant = glob($path . "/" . $pattern);
                if (sizeof($snppCant) > 0){
                    foreach($snppCant as $file){
                        $fileName = basename($file);
                        /**
                         * con el nombre del archivo lo parseo y obtengo los datos de la cabecera.
                         */
                        list($conae, $tipo, $satelite, $instrumento, $fc, $fecha, $hora, $version, $extra) = explode("_", $fileName);
                        $cabecera = new Cabecera([
                            "satelite" => $satelite,
                            "orbita" => null,
                            "fechaHoraPasada" => DateTime::createFromFormat("YmdHis", $fecha.$hora),
                            "fechaHoraCatalogacion" => date('Y-m-d H:i:s'),
                            "versionsoftware" => $version
                        ]);
                        $cabecera->save();
                        /**
                         * Tengo la cabecera ahora guardo los puntos!
                         */
                        $isFirst = false;
                        File::lines($file)->slice(1)->each(function ($line){
                            $punto = new Punto($line);
                        });
                        var_dump($cabecera->fechaHoraPasada);
                        var_dump(DateTime::createFromFormat("YmdHis", $fecha.$hora));
                        dd($fileName);
                    }
                }
                $files = File::files($path);
                var_dump($files);
                die();
                break;
        }

    }
}
