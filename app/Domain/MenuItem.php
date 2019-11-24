<?php declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\AddMenuItemFailed;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class MenuItem
{
    /** @var UuidInterface */
    private $id;
    /** @var string */
    private $field;
    /** @var int */
    private $maxDepth;
    /** @var int */
    private $maxChildren;
    /** @var MenuItem[] */
    private $children;

    public function __construct(UuidInterface $id, string $field, int $maxDepth, int $maxChildren)
    {
        if ($maxDepth < 0 || $maxChildren < 0) {
            throw new \DomainException('Could not create menu item');
        }

        $this->id          = $id;
        $this->maxDepth    = $maxDepth;
        $this->maxChildren = $maxChildren;
        $this->children    = [];

        $this->field = $field;
    }

    public function countLayerChildren(int $layerDepth)
    {
        if ($this->maxDepth === $layerDepth) {
            return \count($this->children);
        }

        if ($this->maxDepth < $layerDepth) {
            return 0;
        }

        return array_reduce($this->children, function (int $count, MenuItem $item) use ($layerDepth) {
            return $count + $item->countLayerChildren($layerDepth);
        }, 0);
    }

    public function moveUp(): void
    {
        $this->maxDepth++;
        foreach ($this->children as $child) {
            $child->moveUp();
        }
    }

    public function deleteChildren(): void
    {
        $this->children = [];
    }

    public function addChild(string $field): UuidInterface
    {
        if (\count($this->children) === $this->maxChildren) {
            throw AddMenuItemFailed::maxChildrenExceeded($field);
        }

        $itemId                               = Uuid::uuid4();
        $this->children [$itemId->toString()] = new MenuItem($itemId, $field, $this->maxDepth - 1, $this->maxChildren);
        return $itemId;
    }

    public function findItem(UuidInterface $id): ?MenuItem
    {
        if ($this->id->equals($id)) {
            return $this;
        }

        foreach ($this->children as $child) {
            $item = $child->findItem($id);
            if (null !== $item) {
                return $item;
            }
        }

        return null;
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

    /**
     * @return MenuItem[]
     */
    public function children(): array
    {
        return $this->children;
    }

    public function childCount(): int
    {
        return \count($this->children);
    }

}
