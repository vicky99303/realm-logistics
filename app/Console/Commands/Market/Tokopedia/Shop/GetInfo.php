<?php

namespace App\Console\Commands\Market\Tokopedia\Shop;

use App\Models\Tokopedia\StoreManagemnt;
use App\Models\Tokopedia\tokopediaAuthTokenLifeInfo;
use App\Models\Tokopedia\TokopediaToken;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Exception;

class GetInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getallshopinfo:tokopedia {userId} {tokenId}';

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
            $dataArray = TokopediaToken::find($tokenId)->with('authtokens')->get();
            if ($dataArray->isNotEmpty()) {
                foreach ($dataArray as $single) {
                    $fs_id = $single->app_id;
                    $access_token = $single->authtokens->access_token;
                    try{
                        $client = new Client();
                        $response = $client->request('GET', 'https://fs.tokopedia.net/v1/shop/fs/' . $fs_id . '/shop-info', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $access_token,
                            ]
                        ]);
                        $statusCode = $response->getStatusCode();
                        $content = json_decode($response->getBody(), true);
                        if ($statusCode == 200 && !isset($content['error'])) {
                            $tokenExist = StoreManagemnt::where('user_id', $userId)
                                ->where('token_id', $tokenId)
                                ->where('shop_id', $content['data'][0]['shop_id'])
                                ->first();
                            if ($tokenExist != NULL) {
                                StoreManagemnt::where('user_id', $userId)
                                    ->where('token_id', $tokenId)
                                    ->where('shop_id', $content['data'][0]['shop_id'])
                                    ->update(['suser_id' => $content['data'][0]['user_id'],
                                        'shop_name' => $content['data'][0]['shop_name'],
                                        'logo' => $content['data'][0]['logo'],
                                        'shop_url' => $content['data'][0]['shop_url'],
                                        'is_open' => $content['data'][0]['is_open'],
                                        'status' => $content['data'][0]['status'],
                                        'date_shop_created' => $content['data'][0]['date_shop_created'],
                                        'domain' => $content['data'][0]['domain'],
                                        'admin_id' => isset($content['data'][0]['admin_id'][0]) ? $content['data'][0]['admin_id'][0] : 0,
                                        'reason' => $content['data'][0]['reason'],
                                        'district_id' => $content['data'][0]['district_id'],
                                        'province_name' => $content['data'][0]['province_name'],
                                        'warehouse_id' => $content['data'][0]['warehouses'][0]['warehouse_id'],
                                        'partner_id_Int64' => $content['data'][0]['warehouses'][0]['partner_id']['Int64'],
                                        'partner_id_Valid' => $content['data'][0]['warehouses'][0]['partner_id']['Valid'],
                                        'wshop_id_Int64' => $content['data'][0]['warehouses'][0]['shop_id']['Int64'],
                                        'wshop_id_Valid' => $content['data'][0]['warehouses'][0]['shop_id']['Valid'],
                                        'warehouse_name' => $content['data'][0]['warehouses'][0]['warehouse_name'],
                                        'wdistrict_id' => $content['data'][0]['warehouses'][0]['district_id'],
                                        'district_name' => $content['data'][0]['warehouses'][0]['district_name'],
                                        'city_id' => $content['data'][0]['warehouses'][0]['city_id'],
                                        'city_name' => $content['data'][0]['warehouses'][0]['city_name'],
                                        'province_id' => $content['data'][0]['warehouses'][0]['province_id'],
                                        'wprovince_name' => $content['data'][0]['warehouses'][0]['province_name'],
                                        'wstatus' => $content['data'][0]['warehouses'][0]['status'],
                                        'postal_code' => $content['data'][0]['warehouses'][0]['postal_code'],
                                        'is_default' => $content['data'][0]['warehouses'][0]['is_default'],
                                        'latlon' => $content['data'][0]['warehouses'][0]['latlon'],
                                        'latitude' => $content['data'][0]['warehouses'][0]['latitude'],
                                        'longitude' => $content['data'][0]['warehouses'][0]['longitude'],
                                        'email' => $content['data'][0]['warehouses'][0]['email'],
                                        'address_detail' => $content['data'][0]['warehouses'][0]['address_detail'],
                                        'phone' => $content['data'][0]['warehouses'][0]['phone'],
                                        'subscribe_tokocabang' => $content['data'][0]['subscribe_tokocabang']
                                    ]);
                            } else {
                                $store = new StoreManagemnt;
                                $store->token_id = $tokenId;
                                $store->fs_id = $fs_id;
                                $store->user_id = $userId;
                                $store->shop_id = $content['data'][0]['shop_id'];
                                $store->suser_id = $content['data'][0]['user_id'];
                                $store->shop_name = $content['data'][0]['shop_name'];
                                $store->logo = $content['data'][0]['logo'];
                                $store->shop_url = $content['data'][0]['shop_url'];
                                $store->is_open = $content['data'][0]['is_open'];
                                $store->status = $content['data'][0]['status'];
                                $store->date_shop_created = $content['data'][0]['date_shop_created'];
                                $store->domain = $content['data'][0]['domain'];
                                $store->admin_id = isset($content['data'][0]['admin_id'][0]) ? $content['data'][0]['admin_id'][0] : 0;
                                $store->reason = $content['data'][0]['reason'];
                                $store->district_id = $content['data'][0]['district_id'];
                                $store->province_name = $content['data'][0]['province_name'];
                                $store->warehouse_id = $content['data'][0]['warehouses'][0]['warehouse_id'];
                                $store->partner_id_Int64 = $content['data'][0]['warehouses'][0]['partner_id']['Int64'];
                                $store->partner_id_Valid = $content['data'][0]['warehouses'][0]['partner_id']['Valid'];
                                $store->wshop_id_Int64 = $content['data'][0]['warehouses'][0]['shop_id']['Int64'];
                                $store->wshop_id_Valid = $content['data'][0]['warehouses'][0]['shop_id']['Valid'];
                                $store->warehouse_name = $content['data'][0]['warehouses'][0]['warehouse_name'];
                                $store->wdistrict_id = $content['data'][0]['warehouses'][0]['district_id'];
                                $store->district_name = $content['data'][0]['warehouses'][0]['district_name'];
                                $store->city_id = $content['data'][0]['warehouses'][0]['city_id'];
                                $store->city_name = $content['data'][0]['warehouses'][0]['city_name'];
                                $store->province_id = $content['data'][0]['warehouses'][0]['province_id'];
                                $store->wprovince_name = $content['data'][0]['warehouses'][0]['province_name'];
                                $store->wstatus = $content['data'][0]['warehouses'][0]['status'];
                                $store->postal_code = $content['data'][0]['warehouses'][0]['postal_code'];
                                $store->is_default = $content['data'][0]['warehouses'][0]['is_default'];
                                $store->latlon = $content['data'][0]['warehouses'][0]['latlon'];
                                $store->latitude = $content['data'][0]['warehouses'][0]['latitude'];
                                $store->longitude = $content['data'][0]['warehouses'][0]['longitude'];
                                $store->email = $content['data'][0]['warehouses'][0]['email'];
                                $store->address_detail = $content['data'][0]['warehouses'][0]['address_detail'];
                                $store->phone = $content['data'][0]['warehouses'][0]['phone'];
                                $store->subscribe_tokocabang = $content['data'][0]['subscribe_tokocabang'];
                                $store->save();
                            }
                            return 1;
                        }
                    }catch(Exception $exception){
                       return $exception->getCode();
                    }
                }
            }
        }
    }
}
