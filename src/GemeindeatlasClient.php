<?php

namespace Ryckblick\Gemeindeatlas;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GemeindeatlasClient
{
    private const string API_URL = 'https://gemeindeatlas.hartmann-medienproduktion.de/api/';
    
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ){}

    public function findAll(
        int $page = 1,
        ?string $name = null,
        ?MunicipalityLevelEnum $level = null,
        ?array $regionalkeys = null,
        ?int $population_greater_than = null,
        ?int $population_less_than = null,
    ): ?array
    {
        $query_parts['page'] = $page;

        if($name !== null) $query_parts['name'] = $name;

        if($level !== null) $query_parts['level'] = $level->value;

        if($regionalkeys !== null) $query_parts['regionalkeys'] = implode(',', $regionalkeys);

        if($population_greater_than !== null) $query_parts['bevoelkerung_gesamt[gt]'] = $population_greater_than;

        if($population_less_than !== null) $query_parts['bevoelkerung_gesamt[lt]'] = $population_less_than;


        $response = $this->httpClient
            ->request('GET', self::API_URL . 'municipalities/?' . http_build_query($query_parts))
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
            ->request('GET', self::API_URL . 'municipalities/' . $regionalKey)
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

    public function getAllRegionalKeys(): ?array
    {
        $response = $this->httpClient
            ->request('GET', self::API_URL . 'all/regionalkeys')
        ;

        if ($response->getStatusCode() !== 200) return null;

        return $response->toArray()['member'];

    }

}