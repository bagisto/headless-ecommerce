<?php

namespace Webkul\GraphQLAPI\Events;

use Illuminate\Encryption\Encrypter;
use Symfony\Component\Console\Output\ConsoleOutput;

class ComposerEvents
{
    /**
     * Generate the environment keys.
     *
     * @return void
     */
    public static function generateEnvironmentKeys($components)
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
            $components->error("Failed to write to .env file at {$envPath}. Please check file permissions.");
        } else {
            $components->info('Environment keys generated successfully.');
        }
    }

    /**
     * Post create project.
     */
    public static function postCreateProject(): void
    {
        $output = new ConsoleOutput;

        $output->writeln(file_get_contents(__DIR__.'/../Templates/on-boarding.php'));
    }
}
