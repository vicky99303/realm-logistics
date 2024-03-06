<?php

namespace App\Models\Tokopedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'tokopedia_orders';
    protected $fillable = [
        'fs_id',
        'order_id',
        'is_cod_mitra',
        'accept_partial',
        'invoice_ref_num',
        'device_type',
        'buyer_id',
        'buyer_name',
        'buyer_phone',
        'buyer_email',
        'shop_id',
        'payment_id',
        'payment_date',
        'recipient_name',
        'recipient_phone',
        'address_full',
        'district',
        'city',
        'province',
        'country',
        'postal_code',
        'district_id',
        'city_id',
        'province_id',
        'geo',
        'logistics_shipping_id',
        'logistics_district_id',
        'logistics_city_id',
        'logistics_province_id',
        'logistics_geo',
        'logistics_shipping_agency',
        'logistics_service_type',
        'amt_ttl_product_price',
        'amt_shipping_cost',
        'amt_insurance_cost',
        'amt_ttl_amount',
        'amt_voucher_amount',
        'amt_toppoints_amount',
        'voucher_code',
        'voucher_type',
        'order_status',
        'warehouse_id',
        'fulfill_by',
        'create_time',
        'promo_order_detail_order_id',
        'promo_order_detail_total_cashback',
        'promo_order_detail_total_discount',
        'promo_order_detail_total_discount_product',
        'promo_order_detail_total_discount_shipping',
        'promo_order_detail_total_discount_details',
        'promo_order_detail_summary_promo',
        'encryption_secret',
        'encryption_content',
        'encryption_message'];
}
