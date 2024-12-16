<?php

namespace App\GemeindeatlasClient;

enum MunicipalityLevelEnum: string
{
    case BUNDESLAND = 'bundesland';
    case REGIERUNGSBEZIRK = 'regierungsbezirk';
    case KREIS = 'kreis';
    case GEMEINDEVERBAND = 'gemeindeverband';
    case GEMEINDE = 'gemeinde';

}
