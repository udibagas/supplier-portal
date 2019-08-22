<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorBank;
use App\Http\Requests\VendorBankRequest;

class VendorBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorBank::when($request->keyword, function($q) use ($request) {
                return $q->where('branch', 'LIKE', '%'.$request->keyword.'%');
            })->when($request->vendor_id, function($q) use ($request) {
                return $q->where('vendor_id', $request->vendor_id);
            })
            ->orderBy($request->sort, $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorBankRequest $request)
    {
        return VendorBank::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorBankRequest $request, VendorBank $vendorBank)
    {
        $vendorBank->update($request->all());
        return $vendorBank;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorBank $vendorBank)
    {
        $vendorBank->delete();
        return ['message' => 'Data has been deleted'];
    }
}
