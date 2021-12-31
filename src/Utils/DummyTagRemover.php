<?php

declare(strict_types=1);

namespace App\Utils;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

class DummyTagRemover
{
    public function __construct()
    {
    }

    /**
     * Get Last Tag And Remove it from the source
     */
    public function getTag(array &$tableauTag): array
    {
       $usefullArray = $tableauTag;
       $cleanArray = array_pop($tableauTag);

       $result = array_diff($usefullArray, $cleanArray);

       return $result;
    }
}
