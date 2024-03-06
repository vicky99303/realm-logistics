<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\Product as ProductTokopediaModel;
use App\Models\Tokopedia\tokopediaAuthTokenLifeInfo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Tokopedia\TokopediaToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Tokopeida extends Controller
{
    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($slug = null)
    {
        if ($slug != NULL) {
            if ($slug == 'stock') {
                return redirect()->route('stockDetail');
            } elseif ($slug == 'order') {
                return redirect()->route('orderDetail');
            } elseif ($slug == 'chat') {
                return redirect()->route('chatDetail');
            }elseif ($slug == 'sale-reports') {
                return redirect()->route('sales-detail');
            }
            $data = array(
                'title' => 'Product',
                'productInfo' => ProductTokopediaModel::where('user_id', Auth::user()->id)
                    ->with('getImages')
                    ->with('getCategories')
                    ->with('getStock')
                    ->get(),
                'tokenId' => 0,
                'fs_id' => TokopediaToken::where('user_id', Auth::user()->id)->get(),
                'shop_id' => 0,
            );
            return view('userpanel.market.tokopedia.product.product', $data);
        }
        $tokenDetail = TokopediaToken::where('user_id', Auth::user()->id)->get();
        $data = array(
            'title' => 'Marketplace Tokopedia List',
            'tokenDetail' => $tokenDetail
        );
        return view('userpanel.market.tokopedia.tokopedia', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        $data = array(
            'title' => 'Marketplace Tokopedia List'
        );
        return view('userpanel.market.tokopedia.addtokopedia', $data);
    }

    /**
     * This function is used to insert and update record
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tokopedia_post(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'client_secret' => 'required',
            'app_id' => 'required',
            'base64' => 'required',
        ]);
        $client_id = $request->post('client_id');
        $client_secret = $request->post('client_secret');
        $app_id = $request->post('app_id');
        $base64 = $request->post('base64');
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
            if ($tokenExist == NULL) {
                $token = new TokopediaToken;
                $token->user_id = Auth::user()->id;
                $token->client_id = $client_id;
                $token->client_secret = $client_secret;
                $token->app_id = $app_id;
                $token->base64 = $base64;
                $token->status = 'Authorized';
                $token->save();

                $tokenLTF = new tokopediaAuthTokenLifeInfo;
                $tokenLTF->user_id = Auth::user()->id;
                $tokenLTF->token_id = $token->id;
                $tokenLTF->access_token = $content['access_token'];
                $tokenLTF->event_code = $content['event_code'];
                $tokenLTF->expires_in = $content['expires_in'];
                $tokenLTF->last_login_type = $content['last_login_type'];
                $tokenLTF->sq_check = $content['sq_check'];
                $tokenLTF->token_type = $content['token_type'];
                $tokenLTF->save();
                $message = 'Token Generated Successfully.';
            } else {
                tokopediaAuthTokenLifeInfo::where('token_id', $tokenExist->id)
                    ->update(['access_token' => $content['access_token'],
                        'event_code' => $content['event_code'],
                        'expires_in' => $content['expires_in'],
                        'last_login_type' => $content['last_login_type'],
                        'sq_check' => $content['sq_check'],
                        'token_type' => $content['token_type'],
                        'token_id' => $tokenExist->id
                    ]);
                $message = 'Token Update Successfully.';
            }
        } else {
            $message = $content['error'];
        }
        return redirect()->back()->with('message', $message);
    }
}
