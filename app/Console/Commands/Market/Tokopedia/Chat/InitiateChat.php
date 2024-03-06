<?php

namespace App\Console\Commands\Market\Tokopedia\Chat;

use App\Models\Tokopedia\Category as CategoryModel;
use App\Models\Tokopedia\TokopediaToken;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitiateChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initiatechat:tokopedia {userId} {tokenId}';

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
        a:
        if (isset(TokopediaToken::find($tokenId)->authtokens)) {
            $dataArray = TokopediaToken::find($tokenId)->with('authtokens')->get();
            if ($dataArray->isNotEmpty()) {
                foreach ($dataArray as $single) {
                    $fs_id = $single->app_id;
                    $access_token = $single->authtokens->access_token;
                    dd($access_token);
                    try {
                        $client = new Client();
                        $url = 'https://fs.tokopedia.com/v1/chat/fs/' . $fs_id . '/initiate?order_id=1234';
                        $response = $client->request('GET', $url, [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $access_token,
                            ]
                        ]);
                        $statusCode = $response->getStatusCode();
                        $content = json_decode($response->getBody(), true);
                        dd($content);
                        if ($statusCode == 200 && !isset($content['error'])) {
                            return 1;
                        }
                    } catch (Exception $exception) {
                        Artisan::call('tokopedia:authorization ' . $userId . ' ' . $tokenId);
                        goto a;
                        return $exception->getCode();
                    }
                }
            }
        }
    }
}
