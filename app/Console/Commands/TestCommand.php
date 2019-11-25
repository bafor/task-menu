<?php

namespace App\Console\Commands;

use App\Domain\Menu;
use App\Domain\MenuItem;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:items {layer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = <<<TXT
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
    }
]
TXT;




        $menu = new Menu(Uuid::uuid4(), 4, 5);
        $item1 = $menu->addItem('frist');

//        $exampleInput = json_decode($input, true);
//        foreach ($exampleInput as $item) {
//            $menu->addItem($item['field'], $item['children'] ?? []);
//        }


        $item2 = $menu->addItem('Second');
        $item3 = $menu->addItem('third');

        $sub  = $menu->addSubItem($item1, 'sub sub 1');
        $sub2 = $menu->addSubItem($item1, 'sub sub 2');
        $menu->addSubItem($sub, 'hey');
        $menu->addSubItem($sub2, 'ho');

        \App\Menu::saveFromArray($menu->toArray());

        $this->printMenu($menu);
        $menu->removeLayer($this->argument('layer'));
        $this->output->writeln('----------');
        $this->printMenu($menu);
    }

    private function printMenu(Menu $menu)
    {
        foreach ($menu->children() as $item) {
            $this->showItem($item, 0);
        }
    }

    private function showItem(MenuItem $item, int $level)
    {
        $this->output->writeln(str_repeat('   ', $level) . ' ' . $item->field() . ' [' . $item->maxDepth() . ']');
        foreach ($item->children() as $child) {
            $this->showItem($child, $level + 1);
        }
    }
}
