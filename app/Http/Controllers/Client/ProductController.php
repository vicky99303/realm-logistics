<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tokopedia\Category;
use App\Models\Tokopedia\Category as CategoryModel;
use App\Models\Tokopedia\Etalase;
use App\Models\Tokopedia\Product;
use App\Models\Tokopedia\TokopediaToken;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = array(
            'title' => 'Product1',
            'productInfo' => collect(),
            'fs_id' => TokopediaToken::where('user_id', Auth::user()->id)->get()
        );
        return view('userpanel.market.product.product', $data);
    }

    public function marketplace()
    {
        $data = array(
            'title' => 'MarketPlace',
            'breadCrumb' => 'Product',
            'slug' => 'product'
        );
        return view('userpanel.market.marketplace', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function new_product()
    {
        $data = array(
            'title' => 'New Product',
            'fs_id' => TokopediaToken::where('user_id', Auth::user()->id)->get()
        );
        return view('userpanel.market.product.new_product', $data);
    }

    /**
     * This function is used to inactive prdouct of live site.
     *
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteProduct(Request $request)
    {
        a:
        $id = $request->input('id');
        $fs_id = $request->input('fs_id');
        $product_id = $request->input('product_id');
        $shop_id = $request->input('shop_id');
        $dataArray = TokopediaToken::where('app_id', $fs_id)
            ->with('authtokens')
            ->first();
        $access_token = $dataArray->authtokens->access_token;
        $body = array(
            'product_id' => array((int)$product_id)
        );
        try {
            $client = new Client();
            $url = 'https://fs.tokopedia.net/v1/products/fs/' . $fs_id . '/inactive?shop_id=' . $shop_id;
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'content-type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'body' => json_encode($body)
            ]);
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody(), true);
            if ($statusCode == 200 && !isset($content['error'])) {
                if ($content['data']['succeed_rows'] > 0) {
                    $product = Product::find($id);
                    $product->status = 3;
                    $product->save();
                    return redirect()->back();
                    return response()->json([
                        'status' => 'true',
                        'message' => 'successfully update product status',
                    ]);
                } elseif ($content['data']['failed_rows'] > 0) {
                    return response()->json([
                        'status' => 'false',
                        'message' => $content['data']['failed_rows_data'],
                    ]);
                }
            }
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                Artisan::call('tokopedia:authorization ' . Auth::user()->id . '  ' . $dataArray->authtokens->token_id);
                goto a;
            }
            dd($e);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function undeleteProduct(Request $request)
    {
        a:
        $id = $request->input('id');
        $fs_id = $request->input('fs_id');
        $product_id = $request->input('product_id');
        $shop_id = $request->input('shop_id');
        $dataArray = TokopediaToken::where('app_id', $fs_id)
            ->with('authtokens')
            ->first();
        $access_token = $dataArray->authtokens->access_token;
        $body = array(
            'product_id' => array((int)$product_id)
        );
        try {
            $client = new Client();
            $url = 'https://fs.tokopedia.net/v1/products/fs/' . $fs_id . '/active?shop_id=' . $shop_id;
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'content-type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'body' => json_encode($body)
            ]);
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody(), true);
            if ($statusCode == 200 && !isset($content['error'])) {
                if ($content['data']['succeed_rows'] > 0) {
                    $product = Product::find($id);
                    $product->status = 1;
                    $product->save();
                    return response()->json([
                        'status' => 'true',
                        'message' => 'successfully update product status',
                    ]);
                } elseif ($content['data']['failed_rows'] > 0) {
                    return response()->json([
                        'status' => 'false',
                        'message' => $content['data']['failed_rows_data'],
                    ]);
                }
            }
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                Artisan::call('tokopedia:authorization ' . Auth::user()->id . '  ' . $dataArray->authtokens->token_id);
                goto a;
            }
            dd($e);
        }
    }

    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:product_tokopedia|max:255',
        ]);
        $fs_id = $request->input('fs_id');
        $shop = $request->input('shop');
        $pname = $request->input('name');
        $category = $request->input('category');
        $etalase = $request->input('etalase');
        $description = $request->input('description');
        $price = $request->input('price');
        $status = $request->input('status');
        $min_order = 1;
        $weight = $request->input('weight');
        $weight_unit = $request->input('weight_unit');
        $condition = $request->input('condition');
        $price_currency = $request->input('price_currency');
        $stock = $request->input('stock');

        $dataArray = TokopediaToken::where('app_id', $fs_id)
            ->with('authtokens')
            ->get();
        if ($dataArray->isNotEmpty()) {
            foreach ($dataArray as $single) {
                $access_token = $single->authtokens->access_token;
                $tokenId = $single->authtokens->id;
                $product_img = "https://ecs7.tokopedia.net/img/cache/700/product-1/2017/9/27/5510391/5510391_9968635e-a6f4-446a-84d0-ff3a98a5d4a2.jpg";
                if ($request->hasFile('product_img')) {
                    $product_img = env('APP_URL') . 'public/' . $request->file('product_img')->store('adminpanel/images/product_img');
                }
                Artisan::call('tokopedia:authorization ' . Auth::user()->id . ' ' . $tokenId);
                $product = array(
                    'products' => array(array(
                        'name' => $pname,
                        'condition' => $condition,
                        'etalase' => [
                            'id' => (int)$etalase
                        ],
                        'category_id' => (int)$category,
                        'description' => $description,
                        'price' => (int)$price,
                        'status' => $status,
                        'min_order' => (int)$min_order,
                        'weight' => (int)$weight,
                        'weight_unit' => $weight_unit,
                        'price_currency' => $price_currency,
                        'stock' => (int)$stock,
                        "pictures" => array(
                            array(
                                "file_path" => $product_img),
                        ),
                    ),
                    )
                );
                try {
                    $client = new Client();
                    $url = 'https://fs.tokopedia.net/v2/products/fs/' . $fs_id . '/create?shop_id=' . $shop;
                    $response = $client->request('POST', $url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $access_token,
                            'content-type' => 'application/json',
                            'Accept' => 'application/json'
                        ],
                        'body' => json_encode($product)
                    ]);
                    $statusCode = $response->getStatusCode();
                    $content = json_decode($response->getBody(), true);
                    if ($statusCode == 200 && !isset($content['error'])) {
                        $responseUploadValue = $this->checkUploadStatus($fs_id, $shop, $access_token, $content['data']['upload_id']);
                        if ($responseUploadValue['data']['success_rows'] >= 1) {
                            return redirect()->route('tokopedia-product-refresh', ['tokenId' => 0, 'fs_id' => 0, 'shop_id' => 0]);
                        } elseif ($responseUploadValue['data']['failed_rows'] >= 1) {

                        } elseif ($responseUploadValue['data']['unprocessed_rows'] >= 1) {

                        }
                    }
                } catch (Exception $e) {
                    dd($e);
                }
            }
        }
    }

    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function editProduct(Request $request)
    {
        $fs_id = $request->input('fs_id');
        $shop = $request->input('shop');
        $id = $request->input('product_id');
        $pname = $request->input('name');
        $category = $request->input('category');
        $description = $request->input('description');
        $price = $request->input('price');
        $status = $request->input('status');
        $min_order = $request->input('min_order');
        $weight = $request->input('weight');
        $weight_unit = $request->input('weight_unit');
        $condition = $request->input('condition');
        $price_currency = $request->input('price_currency');
        $stock = $request->input('stock');
        $dataArray = TokopediaToken::where('app_id', $fs_id)
            ->with('authtokens')
            ->get();
        if ($dataArray->isNotEmpty()) {
            foreach ($dataArray as $single) {
                $access_token = $single->authtokens->access_token;
                $tokenId = $single->authtokens->id;
                Artisan::call('tokopedia:authorization ' . Auth::user()->id . ' ' . $tokenId);
                $product = array();
                if ($request->hasFile('product_img')) {
                    $product_img = env('APP_URL') . 'public/' . $request->file('product_img')->store('adminpanel/images/product_img');
                    $product = array(
                        'products' => array(array(
                            'id' => (int)$id,
                            'name' => $pname,
                            'condition' => $condition,
                            'category_id' => (int)$category,
                            'description' => $description,
                            'price' => (int)$price,
                            'price_currency' => $price_currency,
                            'status' => $status,
                            'min_order' => (int)$min_order,
                            'weight' => (int)$weight,
                            'weight_unit' => $weight_unit,
                            'stock' => (int)$stock,
                            "pictures" => array(
                                array(
                                    "file_path" => $product_img),
                            ),
                        ),
                        )
                    );
                } else {
                    $product = array(
                        'products' => array(array(
                            'id' => (int)$id,
                            'name' => $pname,
                            'condition' => $condition,
                            'category_id' => (int)$category,
                            'description' => $description,
                            'price' => (int)$price,
                            'price_currency' => $price_currency,
                            'status' => $status,
                            'min_order' => (int)$min_order,
                            'weight' => (int)$weight,
                            'weight_unit' => $weight_unit,
                            'stock' => (int)$stock,
                        ),
                        )
                    );
                }
                try {
                    $client = new Client();
                    $url = 'https://fs.tokopedia.net/v2/products/fs/' . $fs_id . '/edit?shop_id=' . $shop;
                    $response = $client->request('PATCH', $url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $access_token,
                            'content-type' => 'application/json',
                            'Accept' => 'application/json'
                        ],
                        'body' => json_encode($product)
                    ]);
                    $statusCode = $response->getStatusCode();
                    $content = json_decode($response->getBody(), true);
                    if ($statusCode == 200 && !isset($content['error'])) {
                        $responseUploadValue = $this->checkUploadStatus($fs_id, $shop, $access_token, $content['data']['upload_id']);
                        return redirect()->route('tokopedia-product-refresh', ['tokenId' => 0, 'fs_id' => 0, 'shop_id' => 0]);
                    }
                } catch (Exception $e) {
                    dd($e);
                }
            }
        }
    }

    /**
     * @param $fs_id
     * @param $shop
     * @param $access_token
     * @param $upload_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function checkUploadStatus($fs_id, $shop, $access_token, $upload_id)
    {
        $client = new Client();
        $url = 'https://fs.tokopedia.net/v2/products/fs/' . $fs_id . '/status/' . $upload_id . '?shop_id=' . $shop;
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
            ]
        ]);
        $content = json_decode($response->getBody(), true);
        return $content;
    }
}
