<?php

namespace App\Api\Post\Repository;


use App\Api\Post\Entity\District;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class DistrictRepository
{

    private $client;

    public function __construct(HttpClientInterface $client = null)
    {
        if ($client) {
            $this->client = $client;
        } else {
            $this->client = new NativeHttpClient();
        }

    }

    public function findByZip(int $zip)
    {
        $district = new District();

        $response = $this->client->request('GET', 'https://swisspost.opendatasoft.com/api/records/1.0/search/?dataset=plz_verzeichnis_v2&q=' . $zip . '&facet=plz_zz&facet=ortbez18');
        $content  = $response->toArray();


        $district->setZip($zip);
        $district->getCity($content['records'][0]['fields']['kanton']);

        return $district;
    }
}
