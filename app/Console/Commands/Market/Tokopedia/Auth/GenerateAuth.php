<?php

namespace App\Console\Commands\Market\Tokopedia\Auth;

use App\Models\Tokopedia\tokopediaAuthTokenLifeInfo;
use App\Models\Tokopedia\TokopediaToken;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class GenerateAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokopedia:authorization {userId} {tokenId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $tokenId = $this->argument('tokenId');
        $tokenDBValues = TokopediaToken::where('user_id', $userId)
            ->where('id', $tokenId)
            ->get();
        if ($tokenDBValues->isNotEmpty()) {
            $client_id = $tokenDBValues[0]->client_id;
            $client_secret = $tokenDBValues[0]->client_secret;
            $app_id = $tokenDBValues[0]->app_id;
            $base64 = $tokenDBValues[0]->base64;
            $client = new Client();
            $response = $client->request('POST', 'https://accounts.tokopedia.com/token?grant_type=client_credentials', [
                'headers' => [
                    'Authorization' => 'Basic ' . $base64,
                ]
            ]);
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody(), true);
            if ($statusCode == 200 && !isset($content['error'])) {
                $tokenExist = TokopediaToken::where('client_id', $client_id)
                    ->where('client_secret', $client_secret)
                    ->where('app_id', $app_id)
                    ->where('base64', $base64)
                    ->first();
                if ($tokenExist != NULL) {
                    tokopediaAuthTokenLifeInfo::where('user_id', $userId)
                        ->where('token_id', $tokenId)
                        ->update(['access_token' => $content['access_token'],
                            'event_code' => $content['event_code'],
                            'expires_in' => $content['expires_in'],
                            'last_login_type' => $content['last_login_type'],
                            'sq_check' => $content['sq_check'],
                            'token_type' => $content['token_type'],
                            'token_id' => $tokenDBValues[0]->id,
                            'updated_at' =>date('Y-m-d h:i:s')
                        ]);
                } else {
                    $token = new TokopediaToken;
                    $token->user_id = $userId;
                    $token->client_id = $client_id;
                    $token->client_secret = $client_secret;
                    $token->app_id = $app_id;
                    $token->base64 = $base64;
                    $token->status = 'Authorized';
                    $token->save();

                    $tokenLTF = new tokopediaAuthTokenLifeInfo;
                    $tokenLTF->user_id = $userId;
                    $tokenLTF->token_id = $token->id;
                    $tokenLTF->access_token = $content['access_token'];
                    $tokenLTF->event_code = $content['event_code'];
                    $tokenLTF->expires_in = $content['expires_in'];
                    $tokenLTF->last_login_type = $content['last_login_type'];
                    $tokenLTF->sq_check = $content['sq_check'];
                    $tokenLTF->token_type = $content['token_type'];
                    $tokenLTF->save();
                }
            }
        }
    }
}
