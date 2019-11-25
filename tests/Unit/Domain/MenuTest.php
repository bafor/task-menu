<?php declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Exception\AddMenuItemFailed;
use App\Domain\Exception\ItemsOnLayerBelowExceedChildrenLimit;
use App\Domain\Menu;
use App\Domain\MenuItem;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class MenuTest extends TestCase
{

    public function testCreateMenu()
    {
        $id          = Uuid::uuid4();
        $maxDepth    = 1;
        $maxChildren = 2;
        $menu        = new Menu($id, $maxDepth, $maxChildren);

        self::assertEquals($id, $menu->id());
        self::assertEquals($maxDepth, $menu->maxDepth());
        self::assertEquals($maxChildren, $menu->maxChildren());
        self::assertEquals([], $menu->children());

        self::assertEquals([
            'id' => $id->toString(),
            'max_depth' => $maxDepth,
            'max_children' => $maxChildren,
            'children' => []
        ], $menu->toArray());
    }

    public function testMenuCreationWithoutItems()
    {
        $this->expectException(\DomainException::class);
        $maxDepth    = 1;
        $maxChildren = 0;
        $this->createMenu($maxDepth, $maxChildren);
    }

    public function testMenuCreationWithoutNoLayers()
    {
        $this->expectException(\DomainException::class);
        $maxDepth    = 0;
        $maxChildren = 2;
        $this->createMenu($maxDepth, $maxChildren);
    }

    public function testAddingItemsToMenu()
    {
        $maxDepth    = 1;
        $maxChildren = 1;
        $menu        = $this->createMenu($maxDepth, $maxChildren);

        $itemField = 'first position';
        $itemId    = $menu->addItem($itemField);

        self::assertCount(1, $menu->children());
        self::assertInstanceOf(MenuItem::class, $menu->children()[0]);

        self::assertEquals($itemField, $menu->children()[0]->field());
        self::assertEquals([], $menu->children()[0]->children());
        self::assertEquals(1, $menu->children()[0]->maxChildren());

        $item = $menu->getItem($itemId);
        self::assertEquals($itemField, $item->field());
        self::assertEquals([], $menu->children()[0]->children());
        self::assertEquals(0, $item->maxDepth());
        self::assertEquals([], $item->children());
        self::assertEquals($item->id(), $menu->children()[0]->id());
    }

    public function testAddingItemsAboveLimit()
    {
        $this->expectException(AddMenuItemFailed::class);
        $maxDepth    = 1;
        $maxChildren = 1;
        $menu        = $this->createMenu($maxDepth, $maxChildren);
        $menu->addItem('first position');
        $menu->addItem('second position');
    }

    public function testAddingItemWithChildren()
    {
        $maxDepth    = 2;
        $maxChildren = 2;
        $menu        = $this->createMenu($maxDepth, $maxChildren);
        $itemId      = $menu->addItem('first position', [['field' => 'sub first']]);

        $item = $menu->getItem($itemId);
        self::assertCount(1, $item->children());
        self::assertEquals('sub first', $item->children()[0]->field());
    }

    public function testRemovingLayerWithTooMuchChildren()
    {
        $this->expectException(ItemsOnLayerBelowExceedChildrenLimit::class);

        $maxDepth    = 10;
        $maxChildren = 2;
        $menu        = $this->createMenu($maxDepth, $maxChildren);
        $menu->addItem(
            'first position', [
                [
                    'field' => 'sub first',

                    'children' => [
                        ['field' => 'sub sub first'],
                        ['field' => 'sub sub first 2']
                    ]

                ]
            ]
        );
        $menu->addItem('second position', [
                [
                    'field' => 'sub second',

                    'children' => [
                        ['field' => 'sub sub second'],
                        ['field' => 'sub sub second 2']
                    ]

                ]
            ]
        );

        $menu->removeLayer(2);
    }

    private function createMenu(int $maxDepth, int $maxChildren): Menu
    {
        return new Menu(Uuid::uuid4(), $maxDepth, $maxChildren);
    }

}
