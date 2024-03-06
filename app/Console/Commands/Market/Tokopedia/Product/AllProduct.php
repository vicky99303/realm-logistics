<?php

namespace App\Console\Commands\Market\Tokopedia\Product;

use App\Models\Tokopedia\Category as CategoryModel;
use App\Models\Tokopedia\ProductImages;
use App\Models\Tokopedia\ProductStock;
use App\Models\Tokopedia\ProductTableCategories;
use App\Models\Tokopedia\ProductTableWareHouseInfo;
use App\Models\Tokopedia\TokopediaToken;
use Exception;
use GuzzleHttp\Client;
use App\Models\Tokopedia\Product as TokopediaProduct;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AllProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getAllProduct:tokopedia  {userId} {tokenId}';

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
                            $param = '?shop_id=' . $singleShop->shop_id . '&page=1&per_page=50&sort=10';
                            $client = new Client();
                            $response = $client->request('GET', 'https://fs.tokopedia.net/inventory/v1/fs/' . $fs_id . '/product/info' . $param, [
                                'headers' => [
                                    'Authorization' => 'Bearer ' . $access_token,
                                ]
                            ]);
                            $statusCode = $response->getStatusCode();
                            $content = json_decode($response->getBody(), true);
                            if ($statusCode == 200 && !isset($content['error'])) {
                                DB::beginTransaction();
                                try {
                                    foreach ($content['data'] as $singleProduct) {
                                        if (isset($singleProduct['basic'])) {
                                            $dataExistProduct = TokopediaProduct::where('fs_id', $fs_id)
                                                ->where('product_id', $singleProduct['basic']['productID'])
                                                ->where('shop_id', $singleProduct['basic']['shopID'])
                                                ->first();
                                            if ($dataExistProduct == NULL) {
                                                $product = new TokopediaProduct;
                                                $product->user_id = $userId;
                                                $product->fs_id = $fs_id;
                                                $product->product_id = $singleProduct['basic']['productID'];
                                                $product->shop_id = $singleProduct['basic']['shopID'];
                                                $product->status = $singleProduct['basic']['status'];
                                                $product->name = $singleProduct['basic']['name'];
                                                $product->must_insurance = $singleProduct['basic']['mustInsurance'];
                                                $product->condition = $singleProduct['basic']['condition'];
                                                $product->child_category_id = $singleProduct['basic']['childCategoryID'];
                                                $product->short_desc = $singleProduct['basic']['shortDesc'];
                                                $product->create_time_unix = $singleProduct['basic']['createTimeUnix'];
                                                $product->update_time_unix = $singleProduct['basic']['updateTimeUnix'];
                                                $product->price_value = $singleProduct['price']['value'];
                                                $product->price_currency = $singleProduct['price']['currency'];
                                                $product->price_last_update_unix = $singleProduct['price']['LastUpdateUnix'];
                                                $product->price_idr = $singleProduct['price']['idr'];
                                                $product->weight_value = $singleProduct['weight']['value'];
                                                $product->weight_unit = $singleProduct['weight']['unit'];
                                                $product->main_stock = $singleProduct['main_stock'];
                                                $product->save();
                                                if (isset($singleProduct['stock'])) {
                                                    $productStock = new ProductStock;
                                                    $productStock->product_id = $product->id;
                                                    $productStock->use_stock = isset($singleProduct['stock']['useStock']) ? $singleProduct['stock']['useStock'] : 0;
                                                    $productStock->value = $singleProduct['stock']['value'];
                                                    $productStock->main_stock = $singleProduct['main_stock'];
                                                    $productStock->save();
                                                }

                                                if (isset($singleProduct['pictures'])) {
                                                    foreach ($singleProduct['pictures'] as $singlePictures) {
                                                        $dataExistProductImages = ProductImages::where('pic_id', $singlePictures['picID'])
                                                            ->first();
                                                        if ($dataExistProductImages == NULL) {
                                                            $productImages = new ProductImages;
                                                            $productImages->product_id = $dataExistProductImages->product_id;
                                                            $productImages->pic_id = $singlePictures['picID'];
                                                            $productImages->file_name = $singlePictures['fileName'];
                                                            $productImages->file_path = $singlePictures['filePath'];
                                                            $productImages->status = $singlePictures['status'];
                                                            $productImages->original_url = $singlePictures['OriginalURL'];
                                                            $productImages->thumbnail_url = $singlePictures['ThumbnailURL'];
                                                            $productImages->width = $singlePictures['width'];
                                                            $productImages->height = $singlePictures['height'];
                                                            $productImages->URL300 = $singlePictures['URL300'];
                                                            $productImages->save();
                                                        } else {
                                                            ProductImages::where('pic_id', $singlePictures['picID'])
                                                                ->update(
                                                                    [
                                                                        'pic_id' => $singlePictures['picID'],
                                                                        'file_name' => $singlePictures['fileName'],
                                                                        'file_path' => $singlePictures['filePath'],
                                                                        'status' => $singlePictures['status'],
                                                                        'original_url' => $singlePictures['OriginalURL'],
                                                                        'thumbnail_url' => $singlePictures['ThumbnailURL'],
                                                                        'width' => $singlePictures['width'],
                                                                        'height' => $singlePictures['height'],
                                                                        'URL300' => $singlePictures['URL300']
                                                                    ]
                                                                );
                                                        }
                                                    }

                                                    if (isset($singleProduct['categoryTree']) && !empty($singleProduct['categoryTree'])) {
                                                        foreach ($singleProduct['categoryTree'] as $category) {
                                                            $dataExistTableCategories = ProductTableCategories::where('product_id', $product->id)
                                                                ->where('cid', $category['id'])
                                                                ->first();
                                                            if ($dataExistTableCategories == NULL) {
                                                                $productCategories = new ProductTableCategories;
                                                                $productCategories->product_id = $product->id;
                                                                $productCategories->cid = $category['id'];
                                                                $productCategories->name = $category['name'];
                                                                $productCategories->title = $category['title'];
                                                                $productCategories->breadcrumb_url = $category['breadcrumbURL'];
                                                                $productCategories->save();
                                                            }
                                                        }
                                                    }
                                                    if (isset($singleProduct['warehouses']) && !empty($singleProduct['warehouses'])) {
                                                        foreach ($singleProduct['warehouses'] as $singleWares) {
                                                                $productWareHouseInfo = new ProductTableWareHouseInfo;
                                                                $productWareHouseInfo->product_id = $product->id;
                                                                $productWareHouseInfo->warehouse_id = $singleWares['warehouseID'];
                                                                $productWareHouseInfo->price = $singleWares['price']['value'];
                                                                $productWareHouseInfo->currency = $singleWares['price']['currency'];
                                                                $productWareHouseInfo->Last_update_unix = $singleWares['price']['LastUpdateUnix'];
                                                                $productWareHouseInfo->idr = $singleWares['price']['idr'];
                                                                $productWareHouseInfo->stock_value = $singleWares['stock']['value'];
                                                                $productWareHouseInfo->use_stock = $singleWares['stock']['useStock'];
                                                                $productWareHouseInfo->save();
                                                        }
                                                    }
                                                }
                                            } else {
                                                TokopediaProduct::where('id', $dataExistProduct->id)
                                                    ->where('product_id', $singleProduct['basic']['productID'])
                                                    ->update(
                                                        [
                                                            'user_id' => $userId,
                                                            'fs_id' => $fs_id,
                                                            'product_id' => $singleProduct['basic']['productID'],
                                                            'shop_id' => $singleProduct['basic']['shopID'],
                                                            'status' => $singleProduct['basic']['status'],
                                                            'name' => $singleProduct['basic']['name'],
                                                            'must_insurance' => $singleProduct['basic']['mustInsurance'],
                                                            'condition' => $singleProduct['basic']['condition'],
                                                            'child_category_id' => $singleProduct['basic']['childCategoryID'],
                                                            'short_desc' => $singleProduct['basic']['shortDesc'],
                                                            'create_time_unix' => $singleProduct['basic']['createTimeUnix'],
                                                            'update_time_unix' => $singleProduct['basic']['updateTimeUnix'],
                                                            'price_value' => $singleProduct['price']['value'],
                                                            'price_currency' => $singleProduct['price']['currency'],
                                                            'price_last_update_unix' => $singleProduct['price']['LastUpdateUnix'],
                                                            'price_idr' => $singleProduct['price']['idr'],
                                                            'weight_value' => $singleProduct['weight']['value'],
                                                            'weight_unit' => $singleProduct['weight']['unit'],
                                                        ]
                                                    );
                                                if (isset($singleProduct['stock'])) {
                                                    ProductStock::where('product_id', $dataExistProduct->id)
                                                        ->update(
                                                            [
                                                                'use_stock' => isset($singleProduct['stock']['useStock']) ? $singleProduct['stock']['useStock'] : 0,
                                                                'value' => $singleProduct['stock']['value'],
                                                                'main_stock' => $singleProduct['main_stock'],
                                                            ]
                                                        );
                                                }

                                                if (isset($singleProduct['pictures'])) {
                                                    foreach ($singleProduct['pictures'] as $singlePictures) {
                                                        $dataExistProductImages = ProductImages::where('pic_id', $singlePictures['picID'])
                                                            ->first();
                                                        if ($dataExistProductImages == NULL) {
                                                            $ProductImagesDelete = ProductImages::where('product_id',(!empty($product->id))?$product->id:$dataExistProduct->id);
                                                            $ProductImagesDelete->delete();
                                                            $productImages = new ProductImages;
                                                            $productImages->product_id = (!empty($product->id))?$product->id:$dataExistProduct->id;
                                                            $productImages->pic_id = $singlePictures['picID'];
                                                            $productImages->file_name = $singlePictures['fileName'];
                                                            $productImages->file_path = $singlePictures['filePath'];
                                                            $productImages->status = $singlePictures['status'];
                                                            $productImages->original_url = $singlePictures['OriginalURL'];
                                                            $productImages->thumbnail_url = $singlePictures['ThumbnailURL'];
                                                            $productImages->width = $singlePictures['width'];
                                                            $productImages->height = $singlePictures['height'];
                                                            $productImages->URL300 = $singlePictures['URL300'];
                                                            $productImages->save();
                                                        } else {
                                                            ProductImages::where('pic_id', $singlePictures['picID'])
                                                                ->update(
                                                                    [
                                                                        'pic_id' => $singlePictures['picID'],
                                                                        'file_name' => $singlePictures['fileName'],
                                                                        'file_path' => $singlePictures['filePath'],
                                                                        'status' => $singlePictures['status'],
                                                                        'original_url' => $singlePictures['OriginalURL'],
                                                                        'thumbnail_url' => $singlePictures['ThumbnailURL'],
                                                                        'width' => $singlePictures['width'],
                                                                        'height' => $singlePictures['height'],
                                                                        'URL300' => $singlePictures['URL300']
                                                                    ]
                                                                );
                                                        }
                                                    }

                                                    if (isset($singleProduct['categoryTree']) && !empty($singleProduct['categoryTree'])) {
                                                        foreach ($singleProduct['categoryTree'] as $category) {
                                                            $dataExistTableCategories = ProductTableCategories::where('product_id', $dataExistProduct->id)
                                                                ->where('cid', $category['id'])
                                                                ->first();
                                                            if ($dataExistTableCategories == NULL) {
                                                                $productCategories = new ProductTableCategories;
                                                                $productCategories->product_id = $dataExistProduct->id;
                                                                $productCategories->cid = $category['id'];
                                                                $productCategories->name = $category['name'];
                                                                $productCategories->title = $category['title'];
                                                                $productCategories->breadcrumb_url = $category['breadcrumbURL'];
                                                                $productCategories->save();
                                                            } else {
                                                                ProductTableCategories::where('cid', $category['id'])
                                                                    ->update(
                                                                        [
                                                                            'cid' => $category['id'],
                                                                            'name' => $category['name'],
                                                                            'title' => $category['title'],
                                                                            'breadcrumb_url' => $category['breadcrumbURL']
                                                                        ]
                                                                    );
                                                            }
                                                        }
                                                    }
                                                    if (isset($singleProduct['warehouses']) && !empty($singleProduct['warehouses'])) {
                                                        foreach ($singleProduct['warehouses'] as $singleWares) {
                                                            $dataExistWareHouseInfo = ProductTableWareHouseInfo::where('product_id', $dataExistProduct->id)
                                                                ->first();
                                                            if ($dataExistWareHouseInfo == NULL) {
                                                                $productWareHouseInfo = new ProductTableWareHouseInfo;
                                                                $productWareHouseInfo->product_id = $product->id;
                                                                $productWareHouseInfo->warehouse_id = $singleWares['warehouseID'];
                                                                $productWareHouseInfo->price = $singleWares['price']['value'];
                                                                $productWareHouseInfo->currency = $singleWares['price']['currency'];
                                                                $productWareHouseInfo->Last_update_unix = $singleWares['price']['LastUpdateUnix'];
                                                                $productWareHouseInfo->idr = $singleWares['price']['idr'];
                                                                $productWareHouseInfo->stock_value = $singleWares['stock']['value'];
                                                                $productWareHouseInfo->use_stock = $singleWares['stock']['useStock'];
                                                                $productWareHouseInfo->save();
                                                            } else {
                                                                ProductTableWareHouseInfo::where('warehouse_id', $singleWares['warehouseID'])
                                                                    ->update(
                                                                        [
                                                                            'warehouse_id' => $singleWares['warehouseID'],
                                                                            'price' => $singleWares['price']['value'],
                                                                            'currency' => $singleWares['price']['currency'],
                                                                            'Last_update_unix' => $singleWares['price']['LastUpdateUnix'],
                                                                            'idr' => $singleWares['price']['idr'],
                                                                            'stock_value' => $singleWares['stock']['value'],
                                                                            'use_stock' => $singleWares['stock']['useStock'],
                                                                        ]
                                                                    );
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    DB::commit();
                                    return 1;
                                } catch (Exception $e) {
                                    DB::rollBack();
                                    return $e->getCode();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
