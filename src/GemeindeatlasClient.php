<?php

namespace Ryckblick\Gemeindeatlas;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GemeindeatlasClient
{
    private const string API_ENDPOINT = 'https://gemeindeatlas.hartmann-medienproduktion.de/api/';
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ){}

    public function findAllByName(string $name, ?MunicipalityLevelEnum $level = null, int $page = 1): ?array
    {
        $query_parts = [
            'page' => $page,
            'name' => $name
        ];
        if($level !== null) $query_parts['level'] = $level->value;

        $response = $this->httpClient
            ->request('GET', self::API_ENDPOINT . 'municipalities/?' . http_build_query($query_parts))
        ;

        if ($response->getStatusCode() !== 200) return null;

        $returnArray = [];
        foreach ($response->toArray()['member'] as $rawMunicipality) {
            $returnArray[] = new MunicipalityDto(
                name: $rawMunicipality['name'],
                flaeche: $rawMunicipality['flaeche'],
                regionalKey: $rawMunicipality['regionalKey'],
                shortName: $rawMunicipality['shortName'],
                bevoelkerungGesamt: $rawMunicipality['bevoelkerungGesamt'],
                bevoelkerungDichte: $rawMunicipality['bevoelkerungDichte'],
            );
        }

        return $returnArray;
    }

    public function getMunicipalityByRegionalKey(string $regionalKey): ?MunicipalityDto
    {
        $response = $this->httpClient
            ->request('GET', self::API_ENDPOINT . 'municipalities/' . $regionalKey)
        ;

        if ($response->getStatusCode() != 200) return null;


        $response = $response->toArray();

        return new MunicipalityDto(
            name: $response['name'],
            flaeche: $response['flaeche'],
            regionalKey: $response['regionalKey'],
            shortName: $response['shortName'],
            bevoelkerungGesamt: $response['bevoelkerungGesamt'],
            bevoelkerungDichte: $response['bevoelkerungDichte'],
        );
    }

}