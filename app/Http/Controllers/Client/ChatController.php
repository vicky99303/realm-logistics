<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\TokopediaToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ChatController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'MarketPlace',
            'breadCrumb' => 'Chat',
            'slug' => 'chat'
        );
        return view('userpanel.market.marketplace', $data);
    }

    public function chatDetail()
    {
        try {
            $client = new Client();
            $url = 'https://fs.tokopedia.com/v1/chat/fs/14543/initiate?order_id=701868182';
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . 'c:9JQZ_6isT-W5_wWWJ1UO7w',
                ]
            ]);
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody(), true);
            dd($content);
            if ($statusCode == 200 && !isset($content['error'])) {
                return 1;
            }
        } catch (Exception $exception) {
            dd($exception);
            Artisan::call('tokopedia:authorization ' . 2 . ' ' . $single->authtokens->token_id);
            goto a;
            return $exception->getCode();
        }
        die;
        a:
        $dataArray = TokopediaToken::find(1)
            ->with('authtokens')
            ->with('getOrderDetail')
            ->get();
        if ($dataArray->isNotEmpty()) {
            foreach ($dataArray as $single) {
                //dd($single);
                $fs_id = $single->app_id;
                $access_token = $single->authtokens->access_token;
                foreach ($single->getOrderDetail as $singleOrder) {
                    try {
                        $client = new Client();
                        $url = 'https://fs.tokopedia.com/v1/chat/fs/' . $fs_id . '/initiate?order_id=' . $singleOrder->order_id;
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
                        dd($exception);
                        Artisan::call('tokopedia:authorization ' . 2 . ' ' . $single->authtokens->token_id);
                        goto a;
                        return $exception->getCode();
                    }
                }
            }
        }
        $data = array(
            'title' => 'Chat'
        );
        return view('userpanel.market.tokopedia.chat.chat', $data);
    }
}
