<?php declare(strict_types=1);

namespace App\Domain\Exception;

class ItemsOnLayerBelowExceedChildrenLimit extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Items count in layer below exceed max children count');
    }
}
