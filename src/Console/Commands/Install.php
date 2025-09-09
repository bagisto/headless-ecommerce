<?php

namespace Webkul\GraphQLAPI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
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
        $this->generateEnvironmentKeys();

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

    /**
     * Generate the environment keys.
     *
     * @return void
     */
    protected function generateEnvironmentKeys()
    {
        $key = base64_encode(Encrypter::generateKey(config('app.cipher')));

        $graphqlEndpoint = rtrim(env('APP_URL'), '/').'/graphql';

        $envPath = base_path('.env');

        $envContent = file_get_contents($envPath);

        $updates = [
            'APP_SECRET_KEY'               => "base64:{$key}",
            'GRAPHQL_ENDPOINT'             => $graphqlEndpoint,
            'JWT_TTL'                      => 525600,
            'JWT_SHOW_BLACKLIST_EXCEPTION' => 'true',
        ];

        foreach ($updates as $envKey => $envValue) {
            $pattern = "/^{$envKey}=.*$/m";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$envKey}={$envValue}", $envContent);
            } else {
                $envContent .= PHP_EOL."{$envKey}={$envValue}";
            }
        }

        $result = file_put_contents($envPath, trim($envContent).PHP_EOL);

        if ($result === false) {
            $this->components->error("Failed to write to .env file at {$envPath}. Please check file permissions.");

            return;
        }
    }
}
