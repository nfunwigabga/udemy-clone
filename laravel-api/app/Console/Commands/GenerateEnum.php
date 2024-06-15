<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateEnum extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:enum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Enum';

    protected $type = 'Enum';

    protected function getStub()
    {
        return __DIR__.'/stubs/enum.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Enums';
    }
}
