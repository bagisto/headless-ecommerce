<?php

namespace Webkul\GraphQLAPI\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * Holds the execution signature of the command needed
     * to be executed for generating super user
     */
    protected $signature = 'bagisto-graphql:install';

    /**
     * Will inhibit the description related to this
     * command's role
     */
    protected $description = 'Installing Bagisto GraphQL API Extension';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Does the all sought of lifting required to be performed for
     * generating a super user
     */
    public function handle()
    {
        // running `php artisan jwt:secret`
        $this->warn('Step: Generating JWT Secret token...');
        $jwt_secret = $this->call('jwt:secret');
        $this->info($jwt_secret);

        // running `php artisan migrate`
        $this->warn('Step: Migrating Notification tables into database...');
        $migrate = $this->call('migrate');
        $this->info($migrate);
        
        // running `php artisan vendor:publish --provider "GraphQLAPIServiceProvider"`
        $this->warn('Step: Publishing GraphQLAPI Provider File...');
        $result = shell_exec('php artisan vendor:publish --tag=graphql-api-lighthouse');
        $this->info($result);
        
        // running `php artisan vendor:publish --provider "Nuwave\Lighthouse\LighthouseServiceProvider" --tag=config`
        $this->warn('Step: Publishing Lighthouse Provider File...');
        $configuration = shell_exec('php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=config');
        $this->info($configuration);

        // running `php artisan vendor:publish --tag=lighthouse-config`
        $this->warn('Step: Publishing Lighthouse Configuration File...');
        $lighthouse_config = shell_exec('php artisan vendor:publish --tag=lighthouse-config');
        $this->info($lighthouse_config);

        // running `composer dump-autoload`
        $this->warn('Step: Composer autoload...');
        $result = shell_exec('composer dump-autoload');
        $this->info($result);

        // running `php artisan cache:clear`
        $this->warn('Step: Clearing the cache...');
        $cache_clear = $this->call('optimize:clear');
        $this->info($cache_clear);
        
        $this->comment('Success: Bagisto GraphQL API has been configured successfully.');
    }
}