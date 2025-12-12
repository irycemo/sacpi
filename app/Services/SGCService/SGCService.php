<?php

namespace App\Services\SGCService;

use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;

class SGCService{

    public function registrarPagoIsai(int $aviso_id):array
    {

        $response = Http::withToken(config('services.sgc.token'))
                            ->accept('application/json')
                            ->asForm()
                            ->post(
                                config('services.sgc.registrar_pago_isai'),
                                [
                                    'id' => $aviso_id,
                                ]
                            );

        if($response->status() !== 200){

            Log::error("Error al registrar pago de ISAI. " . $response);

            $data = json_decode($response, true);

            if(isset($data['error'])){

                throw new GeneralException($data['error']);

            }

            throw new GeneralException("Error al registrar pago de ISAI.");

        }else{

            return json_decode($response, true);

        }

    }

}