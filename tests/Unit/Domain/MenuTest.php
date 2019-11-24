<?php declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\MenuItem;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class MenuTest extends TestCase
{

    public function testdummyTest()
    {
        $id   = Uuid::uuid4();
        $menu = new MenuItem($id, 'name', 1, 2);

        self::assertEquals($id, $menu->id());
        self::assertEquals('name', $menu->field());
        self::assertEquals(1, $menu->maxDepth());
        self::assertEquals(2, $menu->maxChildren());
        self::assertEquals([], $menu->children());
    }
}
