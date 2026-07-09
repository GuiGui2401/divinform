<?php

namespace App\Exceptions;

use RuntimeException;

/** Règle métier de stock violée (stock négatif, quantité incohérente…). */
class StockException extends RuntimeException
{
}
