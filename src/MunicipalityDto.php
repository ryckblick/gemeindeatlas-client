<?php

namespace Ryckblick\Gemeindeatlas;

class MunicipalityDto
{

    public function __construct(
        private string $name,
        private string $gebietsart,
        private float $flaeche,
        private string $regionalKey,
        private string $shortName,
        private int $bevoelkerungGesamt,
        private int $bevoelkerungDichte
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getGebietsart(): string
    {
        return $this->gebietsart;
    }

    public function getFlaeche(): float
    {
        return $this->flaeche;
    }

    public function getRegionalKey(): string
    {
        return $this->regionalKey;
    }
    
    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getBevoelkerungGesamt(): int
    {
        return $this->bevoelkerungGesamt;
    }

    public function getBevoelkerungDichte(): int
    {
        return $this->bevoelkerungDichte;
    }


}