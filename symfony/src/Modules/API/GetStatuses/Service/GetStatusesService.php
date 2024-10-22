<?php

namespace App\Modules\API\GetStatuses\Service;

use App\Modules\API\GetStatuses\Exception\RequestException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetStatusesService
{
    public const TOKEN = 'ba67df6a-a17c-476f-8e95-bcdb75ed3958';

    /**
     * @throws RequestException
     */
    public function getStatuses(): string
    {
        $client = HttpClient::create();

        try {
            $response = $client->request('POST', 'https://crm.belmar.pro/api/v1/getstatuses', [
                'headers' => [
                    'token' => self::TOKEN
                ]
            ]);

        }catch (TransportExceptionInterface $e) {
            throw new RequestException($e->getMessage());
        }

        return $response->getContent();
    }

}