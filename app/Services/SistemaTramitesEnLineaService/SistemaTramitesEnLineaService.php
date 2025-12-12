<?php

namespace App\Services\SistemaTramitesEnLineaService;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SistemaTramitesEnLineaService{

    public function consultarAvisos(int|null $año, int|null $folio, int|null $usuario, int|null $localidad, int|null $oficina, int|null $tipo_predio, int|null $numero_registro, int $pagina_actual, int $pagination):array
    {

        $response = Http::withToken(config('services.sistema_tramites_en_linea.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sistema_tramites_en_linea.consultar_avisos'),
                                [
                                    'año' => $año,
                                    'folio' => $folio,
                                    'usuario' => $usuario,
                                    'localidad' => $localidad,
                                    'oficina' => $oficina,
                                    'tipo_predio' => $tipo_predio,
                                    'numero_registro' => $numero_registro,
                                    'pagina' => $pagina_actual,
                                    'pagination' => $pagination,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al consultar avisos. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al consultar avisos.");

        }else{

            return json_decode($response, true);

        }

    }

}