<?php declare(strict_types=1);

namespace App\Domain\Exception;

class AddMenuItemFailed extends \DomainException
{
    public static function maxDepthExceed(string $name): AddMenuItemFailed
    {
        return new self('Add item ' . $name . ' failed. Max Depth Exceeded');
    }

    public static function maxChildrenExceeded(string $name): AddMenuItemFailed
    {
        return new self('Add item ' . $name . ' failed. Max children Exceeded');
    }

}
