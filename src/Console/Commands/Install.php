<?php

namespace Webkul\GraphQLAPI\Console\Commands;

use Illuminate\Console\Command;
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
        $this->warn('Step1: Generating JWT Secret token...');
        $this->call('jwt:secret');

        $this->warn('Step2: Migrating Notification tables into database...');
        $this->call('migrate');

        $this->warn('Step3: Publishing GraphQLAPI Provider File...');
        $this->info($this->call('vendor:publish', [
            '--provider' => GraphQLAPIServiceProvider::class,
            '--force'    => true
        ]));

        $this->warn('Step: Publishing Lighthouse Provider File...');
        $this->info(shell_exec('php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=config'));

        $this->warn('Step: Publishing GraphiQL Provider File...');
        $this->info(shell_exec('php artisan vendor:publish --provider="MLL\GraphiQL\GraphiQLServiceProvider" --tag=config'));

        $this->warn('Step: Publishing GraphiQL Configuration File...');
        $this->info(shell_exec('php artisan vendor:publish --tag=graphiql-config'));

        $this->warn('Step: Clearing the cache...');
        $this->call('optimize:clear');

        $this->comment('Success: Bagisto GraphQL API has been configured successfully.');
    }
}
