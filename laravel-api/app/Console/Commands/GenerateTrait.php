<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateTrait extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Trait';

    protected $type = 'Trait';

    protected function getStub()
    {
        return __DIR__.'/stubs/trait.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Traits';
    }
}
