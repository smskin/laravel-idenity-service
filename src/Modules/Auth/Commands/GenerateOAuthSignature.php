<?php

namespace SMSkin\IdentityService\Modules\Auth\Commands;

use Illuminate\Console\Command;

class GenerateOAuthSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'identity-service:auth:oauth:generate-signature {callback-url} {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate signature for OAuth methods';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $callbackUrl = sha1($this->argument('callback-url'));
        $key = $this->argument('key');
        $source = $callbackUrl . '|' . config('identity-service.modules.signature.token') . '|' . $key;
        $signature = sha1(strtolower($source));
        $this->info('Signature: ' . $signature);
        return 0;
    }
}
