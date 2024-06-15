<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Laravel\Scout\Searchable;
use ReflectionClass;
use SplFileInfo;

class ScoutRefreshAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:refresh-all {--dir=app} {--namespace=App}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush and import all models with the "Searchable" trait';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getFilesFromDirectory()
            ->each(function (SplFileInfo $fileInfo) {
                $this->handleFile($fileInfo);
            });

        return 0;
    }

    protected function scoutCmd($cmd, $class)
    {
        $escapedClass = str_replace('\\', '\\\\', $class);
        $exitCode = Artisan::call("scout:$cmd $escapedClass");
        $this->artisanOutput($exitCode);
    }

    protected function artisanOutput($exitCode)
    {
        if ($exitCode === 0) {
            $this->info(Artisan::output());
        } else {
            $this->warn(Artisan::output());
        }
    }

    /**
     * @return string
     */
    protected function getClassNameFromSplFileInfo(SplFileInfo $fileInfo)
    {
        $dir = str_replace('\\', '/', $this->option('dir'));
        $dir = str_replace('/', '\/', $dir);
        $ns = $this->option('namespace');

        $className = preg_replace("/^$dir/", $ns, $fileInfo->getPathname());
        $className = str_replace('.php', '', $className);
        $className = str_replace(DIRECTORY_SEPARATOR, '\\', $className);
        $className = "\\$className";

        return $className;
    }

    /**
     * @return bool
     */
    protected function hasTrait($class, $trait)
    {
        $traits = array_keys((new ReflectionClass($class))->getTraits());

        return in_array($trait, $traits);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getFilesFromDirectory()
    {
        $files = File::allFiles($this->option('dir'));

        return collect($files);
    }

    protected function handleFile(SplFileInfo $fileInfo)
    {
        $class = $this->getClassNameFromSplFileInfo($fileInfo);

        /*
         * Ignore interfaces
         */
        if (interface_exists($class)) {
            return;
        }

        if (! class_exists($class)) {
            $this->warn("Failed to find class \"$class\", try append --dir= and --namespace");

            return;
        }

        if ($this->hasTrait($class, Searchable::class)) {
            $this->scoutCmd('flush', $class);
            $this->scoutCmd('import', $class);
        }
    }
}
