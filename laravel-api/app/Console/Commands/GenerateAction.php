<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateAction extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Action class';

    protected $type = 'Action';

    protected function getStub()
    {
        return __DIR__.'/stubs/action.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Actions';
    }
}
