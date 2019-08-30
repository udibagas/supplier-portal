<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillablePoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchase_order_vendors')->insert([
            [
                'vendor_id' => 1,
                'po_number' => '100001',
                'po_date' => '2019-08-01',
                'currency' => 'IDR',
                'po_item' => '10',
                'description' => "Jasa pembuatan aplikasi supplier portal",
                'qty' => 1,
                'uom' => 'ea',
                'price' => 20000000,
                'total' => 20000000,
                'text' => '',
                'delivery_date' => '2019-08-09',
                'gr_status' => 1,
                'invoice_status' => 0,
            ],
            [
                'vendor_id' => 1,
                'po_number' => '100002',
                'po_date' => '2019-08-01',
                'currency' => 'IDR',
                'po_item' => '10',
                'description' => "Jasa pembuatan aplikasi business contract",
                'qty' => 1,
                'uom' => 'ea',
                'price' => 30000000,
                'total' => 30000000,
                'text' => '',
                'delivery_date' => '2019-08-09',
                'gr_status' => 1,
                'invoice_status' => 0,
            ],
            [
                'vendor_id' => 1,
                'po_number' => '100003',
                'po_date' => '2019-08-01',
                'currency' => 'IDR',
                'po_item' => '10',
                'description' => "Jasa pembuatan aplikasi waste product",
                'qty' => 1,
                'uom' => 'ea',
                'price' => 30000000,
                'total' => 30000000,
                'text' => '',
                'delivery_date' => '2019-08-09',
                'gr_status' => 1,
                'invoice_status' => 0,
            ],
            [
                'vendor_id' => 1,
                'po_number' => '100004',
                'po_date' => '2019-08-01',
                'currency' => 'IDR',
                'po_item' => '10',
                'description' => "Jasa pembuatan aplikasi b",
                'qty' => 1,
                'uom' => 'ea',
                'price' => 20000000,
                'total' => 20000000,
                'text' => '',
                'delivery_date' => '2019-08-09',
                'gr_status' => 1,
                'invoice_status' => 0,
            ],
            [
                'vendor_id' => 1,
                'po_number' => '100005',
                'po_date' => '2019-08-01',
                'currency' => 'IDR',
                'po_item' => '10',
                'description' => "Jasa pembuatan aplikasi a",
                'qty' => 1,
                'uom' => 'ea',
                'price' => 30000000,
                'total' => 30000000,
                'text' => '',
                'delivery_date' => '2019-08-09',
                'gr_status' => 1,
                'invoice_status' => 0,
            ],
            [
                'vendor_id' => 1,
                'po_number' => '100006',
                'po_date' => '2019-08-01',
                'currency' => 'IDR',
                'po_item' => '10',
                'description' => "Jasa pembuatan aplikasi c",
                'qty' => 1,
                'uom' => 'ea',
                'price' => 30000000,
                'total' => 30000000,
                'text' => '',
                'delivery_date' => '2019-08-09',
                'gr_status' => 1,
                'invoice_status' => 0,
            ],
        ]);
    }
}
