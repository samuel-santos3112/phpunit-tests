<?php


namespace App\Model\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self MENOR
 * @method static self MAIOR
 */
class TipoAvaliacao extends Enum
{
    const MENOR         = '1';
    const MAIOR         = '2';
    const TRESMAIORES   = '3';
}