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
        if ($layer < 1) {
            throw new \DomainException('Can\t delete layer lower than 1');
        }

        if ($this->countLayerChildren($layer) > $this->maxDepth) {
            throw new \DomainException('Can\'t remove layer number. Shifted next layer will exceed max children limit');
        }

        $layerMaxDepth = $this->maxDepth - $layer;

        if ($layerMaxDepth + 1 === $this->maxDepth) {
            $this->children = array_merge(
                ...array_map(function (MenuItem $item) {
                    $item->moveUp();
                    return $item->children();
                }, $this->children)
            );
            return;
        }

        foreach ($this->children as $item) {
            $item->removeLayer($layerMaxDepth);
        }
    }

    private function countLayerChildren(int $layer)
    {
        $layerMaxDepth = $this->maxDepth - $layer - 1;
        return array_reduce($this->children, function (int $count, MenuItem $item) use ($layerMaxDepth) : int {
            return $count + $item->countLayerChildren($layerMaxDepth);
        }, 0);
    }

    public function addItem(string $field, array $children = []): UuidInterface
    {
        if (\count($this->children) === $this->maxChildren) {
            throw AddMenuItemFailed::maxChildrenExceeded($field);
        }

        $itemId            = Uuid::uuid4();
        $menuItem          = new MenuItem(
            $itemId,
            $field,
            $this->maxDepth - 1,
            $this->maxChildren
        );
        $this->children [] = $menuItem;

        foreach ($children as $child) {
            $menuItem->addChild($child['field'], $child['children'] ?? []);
        }

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
        foreach ($this->children as $item) {
            $item = $item->findItem($id);
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

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'max_depth' => $this->maxDepth,
            'max_children' => $this->maxChildren,
            'children' => array_map(
                function (MenuItem $item) {
                    return $item->toArray();
                },
                $this->children
            )
        ];
    }

}
