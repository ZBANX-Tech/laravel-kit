<?php

namespace Zbanx\Kit\Providers\Macros;

use Illuminate\Console\Command;

class CommandMacros
{
    public function __invoke()
    {
        $this->print();
    }

    public function print()
    {
        Command::macro('print', function ($string, $style = 'info') {
            /** @var Command $command */
            $command = $this;
            $styles = [
                'info',
                'warn',
                'error',
                'comment',
                'question'
            ];
            if (in_array($style, $styles)) {
                $command->$style('[' . date('Y-m-d H:i:s') . '] ' . $string);
            } else {
                $command->error($style . ' not exits');
            }
        });
    }
}
