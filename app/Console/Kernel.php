<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\TestCommand;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        TestCommand::class
    ];
}
