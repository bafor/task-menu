<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use Ramsey\Uuid\UuidInterface;

class MenuCreateParams
{
    /** @var UuidInterface */
    private $id;
    /** @var int */
    private $maxDepth;
    /** @var int */
    private $maxChildren;
    /** @var string */
    private $field;

    public function __construct(
        UuidInterface $id,
        int $maxDepth,
        int $maxChildren,
        string $field
    )
    {
        $this->id          = $id;
        $this->maxDepth    = $maxDepth;
        $this->maxChildren = $maxChildren;
        $this->field       = $field;
    }

    public static function fromArray(UuidInterface $menuId, array $data): MenuCreateParams
    {
        return new self(
            $menuId,
            $data['max_depth'],
            $data['max_children'],
            $data['field']
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function maxDepth(): int
    {
        return $this->maxDepth;
    }

    public function maxChildren(): int
    {
        return $this->maxChildren;
    }

    public function field(): string
    {
        return $this->field;
    }

}
