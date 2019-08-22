<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorCompanyManagement;
use App\Http\Requests\VendorCompanyManagementRequest;

class VendorCompanyManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorCompanyManagement::when($request->keyword, function($q) use ($request) {
                return $q->where('name', 'LIKE', '%'.$request->keyword.'%');
            })->when($request->vendor_id, function($q) use ($request) {
                return $q->where('vendor_id', $request->vendor_id);
            })
            ->orderBy('name', $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorCompanyManagementRequest $request)
    {
        return VendorCompanyManagement::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorCompanyManagementRequest $request, VendorCompanyManagement $vendorCompanyManagement)
    {
        $vendorCompanyManagement->update($request->all());
        return $vendorCompanyManagement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorCompanyManagement $vendorCompanyManagement)
    {
        $vendorCompanyManagement->delete();
        return ['message' => 'Data has been deleted'];
    }
}
