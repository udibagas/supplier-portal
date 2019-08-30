<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderVendorRequest;
use Illuminate\Http\Request;
use App\PurchaseOrderVendor;

class PurchaseOrderVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PurchaseOrderVendor::selectRaw('purchase_order_vendors.*')
            ->when($request->keyword, function($q) use ($request) {
                return $q->where('po_number', 'LIKE', '%'.$request->keyword.'%')
                         ->orWhere('description', 'LIKE', '%'.$request->keyword.'%');
            })
            ->when($request->vendor_id, function($q) use ($request) {
                return $q
                    ->join('vendors', 'vendors.id', '=', 'purchase_order_vendors.vendor_id')
                    ->where('vendor_id', $request->vendor_id);
            })->orderBy($request->sort, $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderVendorRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
