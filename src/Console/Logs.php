<?php

namespace SierraTecnologia\Builder\Console;

use SierraTecnologia\Builder\Console\SierraTecnologiaCommand;
use SierraTecnologia\Builder\Traits\FileMakerTrait;
use Illuminate\Filesystem\Filesystem;

class Logs extends SierraTecnologiaCommand
{
    use FileMakerTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sierratecnologia:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SierraTecnologia Builder will add a logs listing UI to your app';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->starterIsInstalled()) {
            $fileSystem = new Filesystem();

            $files = $fileSystem->allFiles(__DIR__.'/../Packages/Logs');
            $this->line("\n");
            foreach ($files as $file) {
                $this->line(str_replace(__DIR__.'/../Packages/Logs/', '', $file));
            }

            $this->info("\n\nThese files will be published\n");

            $result = $this->confirm('Are you sure you want to overwrite any files of the same name?');

            if ($result) {
                $this->copyPreparedFiles(__DIR__.'/../Packages/Logs', base_path());
                $this->info("\n\n Please review the setup details for logs.");
                $this->info("\n\n You will want to add things like:");
                $this->line("\n These links: ");
                $this->comment("\n <li class=\"nav-item\"><a class=\"nav-link\" href='{!! url('admin/logs') !!}'><span class='fa fa-chart-line'></span> Logs</a></li>");
                $this->line("\n Now modify the RouteServiceProvider by switching to a closure in the `group` method (app/Providers/RouteServiceProvider.php):");
                $this->line("\n It will look like: ->group(base_path('routes/web.php')); So you need to change it to resemble this:");
                $this->comment("\n ->group(function () {");
                $this->comment("\n require base_path('routes/web.php');");
                $this->comment("\n require base_path('routes/logs.php');");
                $this->comment("\n }");
                $this->info("\n Finished setting up logs");
            } else {
                $this->info("\n You cancelled the sierratecnologia:logs");
            }
        }
    }
}
