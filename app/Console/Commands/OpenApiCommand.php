<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OpenApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openapi:generate {--admin} {--disk=public}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the OpenAPI schema file';

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
        $appDomain = config('app.domain');
        $storageDisk = $this->option('disk');

        $options = [
            'exclude' => [
                'vendor',
                'routes/admin',
            ]
        ];

        $schemaFile = 'openapi.json';

        // generate schema for admin api
        if ($this->option('admin')) {
            $options = [
                'exclude' => [
                    'vendor',
                    'routes/api',
                ]
            ];

            $schemaFile = 'admin' . DIRECTORY_SEPARATOR . 'openapi.json';
        }

        // confirm overwrite when file exists
        if (Storage::disk($storageDisk)->exists($schemaFile) &&
           ! $this->confirm('File already exists! Do you wish to continue?')) {
            return;
        }

        define('APP_DOMAIN', $appDomain);

        $openApi = \OpenApi\scan(
            base_path(),
            $options
        );

        $content = $openApi->toJson();

        Storage::disk($storageDisk)->put($schemaFile, $content);

        $this->info(sprintf(
            'OpenApi schema file \'%s\' was successfully written to the \'%s\' disk.',
            $schemaFile,
            $storageDisk
        ));
    }
}
