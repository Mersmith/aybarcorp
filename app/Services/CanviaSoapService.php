<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CanviaSoapService
{
    public function obtenerConstanciaCancelacion(string $numeroLetra): array
    {
        $soapBody = <<<XML
<soapenv:Envelope
    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:ope="http://operationWS.remote.soap.digitall">
   <soapenv:Header/>
   <soapenv:Body>
      <ope:ObtenerConstanciaCancelacionWS>
         <NumeroLetra>{$numeroLetra}</NumeroLetra>
      </ope:ObtenerConstanciaCancelacionWS>
   </soapenv:Body>
</soapenv:Envelope>
XML;

        $response = Http::withBasicAuth(
            config('services.canvia.user'),
            config('services.canvia.password')
        )
            ->withHeaders([
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction'   => 'ObtenerConstanciaCancelacionWS',
            ])
            ->post(config('services.canvia.url'), $soapBody);

        if (! $response->successful()) {
            throw new \Exception('Error HTTP SOAP: ' . $response->status());
        }

        return $this->parseSoapResponse($response->body());
    }

    private function parseSoapResponse(string $xml): array
    {
        $xmlObject = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xmlObject === false) {
            throw new \Exception('Respuesta SOAP inválida');
        }

        $namespaces = $xmlObject->getNamespaces(true);

        // SOAP Envelope (sin asumir nombre del namespace)
        $soapNs = $namespaces['soap'] ?? $namespaces['soapenv'] ?? null;

        if (! $soapNs) {
            throw new \Exception('Namespace SOAP no encontrado');
        }

        $body = $xmlObject->children($soapNs)->Body;

        // Tomar el primer hijo real del Body (sin asumir nombre)
        $responseNode = $body->children()->children();

        return [
            'codigo' => (string) ($responseNode->CodigoOperacion ?? ''),
            'base64' => (string) ($responseNode->formatoBase64 ?? ''),
        ];
    }
}
