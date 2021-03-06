<?php

namespace App\Console\Commands\OneDrive;

use App\Helpers\Tool;
use App\Http\Controllers\OauthController;
use Illuminate\Console\Command;

class RefreshToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'od:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Token';

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
     * @throws \ErrorException
     */
    public function handle()
    {
        $expires = Tool::config('access_token_expires', 0);
        $hasExpired = $expires - time() <= 0 ? true : false;
        if (!$hasExpired) {
            return;
        } else {
            $oauth = new OauthController();
            $res = json_decode($oauth->refreshToken(false), true);
            $res['code'] === 200 or exit('Refresh Token Error!');
        }
    }
}
