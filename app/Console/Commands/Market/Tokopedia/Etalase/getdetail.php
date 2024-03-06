<?php

namespace App\Console\Commands\Market\Tokopedia\Etalase;

use App\Models\Tokopedia\Etalase;
use App\Models\Tokopedia\TokopediaToken;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class getdetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getAllEtalase:tokopedia  {userId} {tokenId}';

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
        if (isset(TokopediaToken::find($tokenId)->authtokens)) {
            $dataArray = TokopediaToken::find($tokenId)
                ->with('authtokens')
                ->with('getShopInfo')
                ->get();
            if ($dataArray->isNotEmpty()) {
                foreach ($dataArray as $single) {
                    if ($single->getShopInfo->isNotEmpty()) {
                        foreach ($single->getShopInfo as $singleShop) {
                            $fs_id = $single->app_id;
                            $access_token = $single->authtokens->access_token;
                            $client = new Client();
                            $url = 'https://fs.tokopedia.net/inventory/v1/fs/' . $fs_id . '/product/etalase?shop_id=' . $singleShop->shop_id;
                            $response = $client->request('GET', $url, [
                                'headers' => [
                                    'Authorization' => 'Bearer ' . $access_token,
                                ]
                            ]);
                            $statusCode = $response->getStatusCode();
                            $content = json_decode($response->getBody(), true);
                            if ($statusCode == 200 && !isset($content['error'])) {
                                if (isset($content['data']['etalase']) && !empty($content['data']['etalase'])) {
                                    foreach ($content['data']['etalase'] as $singleEtalase) {
                                        $dataExistEtalase = Etalase::where('fs_id', $fs_id)
                                            ->where('shop_id', $singleShop->shop_id)
                                            ->where('etalase_id', $singleEtalase['etalase_id'])
                                            ->first();
                                        if ($dataExistEtalase == NULL) {
                                            $singleEtalaseObj = new Etalase();
                                            $singleEtalaseObj->fs_id = $fs_id;
                                            $singleEtalaseObj->shop_id = $singleShop->shop_id;
                                            $singleEtalaseObj->etalase_id = $singleEtalase['etalase_id'];
                                            $singleEtalaseObj->etalase_name = $singleEtalase['etalase_name'];
                                            $singleEtalaseObj->alias = $singleEtalase['alias'];
                                            $singleEtalaseObj->url = $singleEtalase['url'];
                                            $singleEtalaseObj->save();
                                        } else {
                                            // update value
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
