<?php

namespace Webkul\GraphQLAPI\Console\Commands;

use Illuminate\Console\Command;
use Webkul\GraphQLAPI\Events\ComposerEvents;
use Webkul\GraphQLAPI\Providers\GraphQLAPIServiceProvider;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bagisto-graphql:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing Bagisto GraphQL API Extension';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ComposerEvents::generateEnvironmentKeys($this->components);

        $this->callSilently('jwt:secret', [
            '--force' => true,
        ]);

        $this->components->info('JWT secret key generated successfully.');

        $this->call('migrate', [
            '--path' => 'vendor/bagisto/graphql-api/src/Database/Migrations',
        ]);

        $this->call('vendor:publish', [
            '--provider' => GraphQLAPIServiceProvider::class,
            '--force'    => true,
        ]);

        $this->call('optimize:clear');

        ComposerEvents::postCreateProject();

        $this->components->info('🎉 Bagisto GraphQL API package installed successfully!');
    }
}
