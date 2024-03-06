<?php

namespace App\Console\Commands\Market\Tokopedia\Order;

use App\Models\Tokopedia\OrderDetail;
use App\Models\Tokopedia\OrderDetailFulfilled;
use App\Models\Tokopedia\Orders;
use App\Models\Tokopedia\ProductTableWareHouseInfo;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetAllOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getallorder:tokopedia  {userId} {tokenId}';

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
                            $from_date = time() - (3 * 24 * 60 * 60);
                            $to_date = time() + (0 * 24 * 60 * 60);
                            $param = 'fs_id=' . $fs_id . '&shop_id=' . $singleShop->shop_id . '&from_date=' . $from_date . '&to_date=' . $to_date . '&page=1&per_page=10';
                            $client = new Client();
                            $url = 'https://fs.tokopedia.net/v2/order/list?';
                            $response = $client->request('GET', $url . $param, [
                                'headers' => [
                                    'Authorization' => 'Bearer ' . $access_token,
                                ]
                            ]);
                            $statusCode = $response->getStatusCode();
                            $content = json_decode($response->getBody(), true);
                            if ($statusCode == 200 && !isset($content['error']) && isset($content['data']) && !empty(isset($content['data']))) {
                                foreach ($content['data'] as $singleOrder) {
                                    $dataExistOrderInfo = Orders::where('order_id', $singleOrder['order_id'])->first();
                                    if ($dataExistOrderInfo == NULL) {
                                        $orderObj = new Orders();
                                        $orderObj->fs_id = $fs_id;
                                        $orderObj->order_id = $singleOrder['order_id'];
                                        $orderObj->is_cod_mitra = $singleOrder['is_cod_mitra'];
                                        $orderObj->accept_partial = $singleOrder['accept_partial'];
                                        $orderObj->invoice_ref_num = $singleOrder['invoice_ref_num'];
                                        $orderObj->device_type = $singleOrder['device_type'];
                                        $orderObj->buyer_id = $singleOrder['buyer']['id'];
                                        $orderObj->buyer_name = $singleOrder['buyer']['name'];
                                        $orderObj->buyer_phone = $singleOrder['buyer']['phone'];
                                        $orderObj->buyer_email = $singleOrder['buyer']['email'];
                                        $orderObj->shop_id = $singleOrder['shop_id'];
                                        $orderObj->payment_id = $singleOrder['payment_id'];
                                        $orderObj->payment_date = $singleOrder['payment_date'];
                                        $orderObj->recipient_name = $singleOrder['recipient']['name'];
                                        $orderObj->recipient_phone = $singleOrder['recipient']['phone'];
                                        $orderObj->address_full = $singleOrder['recipient']['address']['address_full'];
                                        $orderObj->district = $singleOrder['recipient']['address']['district'];
                                        $orderObj->city = $singleOrder['recipient']['address']['city'];
                                        $orderObj->province = $singleOrder['recipient']['address']['province'];
                                        $orderObj->country = $singleOrder['recipient']['address']['country'];
                                        $orderObj->postal_code = $singleOrder['recipient']['address']['postal_code'];
                                        $orderObj->district_id = $singleOrder['recipient']['address']['district_id'];
                                        $orderObj->city_id = $singleOrder['recipient']['address']['city_id'];
                                        $orderObj->province_id = $singleOrder['recipient']['address']['province_id'];
                                        $orderObj->geo = $singleOrder['recipient']['address']['geo'];
                                        $orderObj->logistics_shipping_id = $singleOrder['logistics']['shipping_id'];
                                        $orderObj->logistics_district_id = $singleOrder['logistics']['district_id'];
                                        $orderObj->logistics_city_id = $singleOrder['logistics']['city_id'];
                                        $orderObj->logistics_province_id = $singleOrder['logistics']['province_id'];
                                        $orderObj->logistics_geo = $singleOrder['logistics']['geo'];
                                        $orderObj->logistics_shipping_agency = $singleOrder['logistics']['shipping_agency'];
                                        $orderObj->logistics_service_type = $singleOrder['logistics']['service_type'];
                                        $orderObj->amt_ttl_product_price = $singleOrder['amt']['ttl_product_price'];
                                        $orderObj->amt_shipping_cost = $singleOrder['amt']['shipping_cost'];
                                        $orderObj->amt_insurance_cost = $singleOrder['amt']['insurance_cost'];
                                        $orderObj->amt_ttl_amount = $singleOrder['amt']['ttl_amount'];
                                        $orderObj->amt_voucher_amount = $singleOrder['amt']['voucher_amount'];
                                        $orderObj->amt_toppoints_amount = $singleOrder['amt']['toppoints_amount'];
                                        $orderObj->voucher_code = $singleOrder['voucher_info']['voucher_code'];
                                        $orderObj->voucher_type = $singleOrder['voucher_info']['voucher_type'];
                                        $orderObj->order_status = $singleOrder['order_status'];
                                        $orderObj->warehouse_id = $singleOrder['warehouse_id'];
                                        $orderObj->fulfill_by = $singleOrder['fulfill_by'];
                                        $orderObj->create_time = $singleOrder['create_time'];
                                        $orderObj->promo_order_detail_order_id = $singleOrder['promo_order_detail']['order_id'];
                                        $orderObj->promo_order_detail_total_cashback = ($singleOrder['promo_order_detail']['total_cashback'] != '') ? $singleOrder['promo_order_detail']['total_cashback'] : '0';
                                        $orderObj->promo_order_detail_total_discount = ($singleOrder['promo_order_detail']['total_discount'] != '') ? $singleOrder['promo_order_detail']['total_discount'] : '0';
                                        $orderObj->promo_order_detail_total_discount_product = ($singleOrder['promo_order_detail']['total_discount_product'] != '') ? $singleOrder['promo_order_detail']['total_discount_product'] : '0';
                                        $orderObj->promo_order_detail_total_discount_shipping = ($singleOrder['promo_order_detail']['total_discount_shipping'] != '') ? $singleOrder['promo_order_detail']['total_discount_shipping'] : '0';
                                        $orderObj->promo_order_detail_total_discount_details = ($singleOrder['promo_order_detail']['total_discount_details'] != '') ? $singleOrder['promo_order_detail']['total_discount_details'] : '0';
                                        $orderObj->promo_order_detail_summary_promo = ($singleOrder['promo_order_detail']['summary_promo'] != '') ? $singleOrder['promo_order_detail']['summary_promo'] : '';
                                        $orderObj->encryption_secret = ($singleOrder['encryption']['secret'] != '') ? $singleOrder['encryption']['secret'] : 'NA';
                                        $orderObj->encryption_content = ($singleOrder['encryption']['content'] != '') ? $singleOrder['encryption']['content'] : 'NA';
                                        $orderObj->encryption_message = ($singleOrder['encryption']['message'] != '') ? $singleOrder['encryption']['message'] : 'NA';
                                        $orderObj->save();
                                    } else {
                                        // update
                                    }// end else
                                    if (isset($singleOrder['products']) && !empty($singleOrder['products'])) {
                                        foreach ($singleOrder['products'] as $singleProducts) {
                                            $dataExistOrderDetailInfo = OrderDetail::where('products_id', $singleProducts['id'])->first();
                                            if ($dataExistOrderDetailInfo == NULL) {
                                                $orderDetailObj = new OrderDetail();
                                                $orderDetailObj->fk_order_id = $orderObj->id;
                                                $orderDetailObj->order_id = $singleOrder['order_id'];
                                                $orderDetailObj->products_id = $singleProducts['id'];
                                                $orderDetailObj->products_name = $singleProducts['name'];
                                                $orderDetailObj->products_quantity = $singleProducts['quantity'];
                                                $orderDetailObj->products_notes = $singleProducts['notes'];
                                                $orderDetailObj->products_weight = $singleProducts['weight'];
                                                $orderDetailObj->products_total_weight = $singleProducts['total_weight'];
                                                $orderDetailObj->products_price = $singleProducts['price'];
                                                $orderDetailObj->products_total_price = $singleProducts['total_price'];
                                                $orderDetailObj->currency = $singleProducts['currency'];
                                                $orderDetailObj->sku = ($singleProducts['sku'] != '') ? $singleProducts['sku'] : '';
                                                $orderDetailObj->is_wholesale = $singleProducts['is_wholesale'];
                                                $orderDetailObj->save();
                                            } else {
                                                // update value
                                            }// end else
                                        }// endforeach
                                    }// endif

                                    if (isset($singleOrder['products_fulfilled']) && !empty($singleOrder['products_fulfilled'])) {
                                        foreach ($singleOrder['products_fulfilled'] as $singleFulFilledProducts) {
                                            $dataExistOrderDetailFulfilledInfo = OrderDetailFulfilled::where('products_fulfilled_product_id', $singleFulFilledProducts['product_id'])->first();
                                            if ($dataExistOrderDetailFulfilledInfo == NULL) {
                                                $orderDetailFulfilledObj = new OrderDetailFulfilled();
                                                $orderDetailFulfilledObj->fk_order_id = $orderObj->id;
                                                $orderDetailFulfilledObj->order_id = $singleOrder['order_id'];
                                                $orderDetailFulfilledObj->products_fulfilled_product_id = $singleFulFilledProducts['product_id'];
                                                $orderDetailFulfilledObj->products_fulfilled_quantity_deliver = $singleFulFilledProducts['quantity_deliver'];
                                                $orderDetailFulfilledObj->products_fulfilled_quantity_reject = $singleFulFilledProducts['quantity_reject'];
                                                $orderDetailFulfilledObj->save();
                                            } else {
                                                // update value
                                            }
                                        }// endforeach
                                    }// endif
                                }// endforeach
                            }// endif
                        }// endforeach
                    }// endif
                }// endforeach
            }// endif
        }// endif
    }
}
