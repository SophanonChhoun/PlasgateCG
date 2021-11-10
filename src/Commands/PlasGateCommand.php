<?php

namespace Kunlyly\PlasGate\Commands;

use Illuminate\Console\Command;

class PlasGateCommand extends Command
{
    public $signature = 'lyly-cg-otp';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
