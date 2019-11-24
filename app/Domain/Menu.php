<?php declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\AddMenuItemFailed;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Menu
{
    /** @var UuidInterface */
    private $id;
    /** @var int */
    private $maxDepth;
    /** @var int */
    private $maxChildren;
    /** @var MenuItem[] */
    private $children;

    public function __construct(UuidInterface $id, int $maxDepth, int $maxChildren)
    {
        if ($maxDepth < 0 || $maxChildren < 0) {
            throw new \DomainException('Could not create menu item');
        }

        $this->id          = $id;
        $this->maxDepth    = $maxDepth;
        $this->maxChildren = $maxChildren;
        $this->children    = [];
    }

    public function removeLayer(int $layer): void
    {
        $layerMaxDepth = $this->maxDepth - $layer - 1;

        if ($this->countLayerChildren($layer) > $this->maxDepth) {
            throw new \DomainException('Can\'t remove layer number. Shifted next layer will exceed max children limit');
        }

        if ($layerMaxDepth === $this->maxDepth) {
            $this->children = array_merge(
                ...array_map(function (MenuItem $item) {
                    $item->moveUp();
                    return $item->children();
                }, $this->children)
            );
            return;
        }

        $this->children = array_map(function (MenuItem $item) use ($layer) {

        }, $this->children);
    }

    private function countLayerChildren(int $layer)
    {
        $layerMaxDepth = $this->maxDepth - $layer - 1;
        return array_reduce($this->children, function (int $count, MenuItem $item) use ($layerMaxDepth) : int {
            return $count + $item->countLayerChildren($layerMaxDepth);
        }, 0);
    }

    public function addItem(string $field): UuidInterface
    {
        if (\count($this->children) === $this->maxChildren) {
            throw AddMenuItemFailed::maxChildrenExceeded($field);
        }

        $itemId            = Uuid::uuid4();
        $this->children [] = new MenuItem($itemId, $field, $this->maxDepth - 1, $this->maxChildren);
        return $itemId;
    }

    public function deleteItems(): void
    {
        $this->children = [];
    }

    public function deleteSubItems(UuidInterface $itemId): void
    {
        $this->getItem($itemId)->deleteChildren();
    }

    private function getItem(UuidInterface $id): MenuItem
    {
        foreach ($this->children as $child) {
            $item = $child->findItem($id);
            if (null !== $item) {
                return $item;
            }
        }

        throw new \DomainException('Item not found');
    }

    public function addSubItem(UuidInterface $itemId, string $field): UuidInterface
    {
        $item = $this->getItem($itemId);
        return $item->addChild($field);
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function maxDepth(): int
    {
        return $this->maxDepth;
    }

    /**
     * @return MenuItem[]
     */
    public function children(): array
    {
        return $this->children;
    }

}
