<?php

namespace Ryckblick\Gemeindeatlas;

class MunicipalityDto
{

    public function __construct(
        private string $name,
        private float $flaeche,
        private string $regionalKey,
        private $shortName,
        private int $bevoelkerungGesamt,
        private int $bevoelkerungDichte
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getFlaeche(): float
    {
        return $this->flaeche;
    }

    public function getRegionalKey(): string
    {
        return $this->regionalKey;
    }

    /**
     * @return mixed
     */
    public function getShortName()
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