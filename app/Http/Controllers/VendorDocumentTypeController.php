<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorDocumentTypeRequest;
use App\VendorDocumentType;
use Illuminate\Http\Request;

class VendorDocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorDocumentType::when($request->keyword, function($q) use ($request) {
            return $q->where('description', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('name', 'LIKE', '%'.$request->keyword.'%');
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
    public function store(VendorDocumentTypeRequest $request)
    {
        return VendorDocumentType::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorDocumentTypeRequest $request, VendorDocumentType $vendorDocumentType)
    {
        $vendorDocumentType->update($request->all());
        return $vendorDocumentType;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorDocumentType $vendorDocumentType)
    {
        $vendorDocumentType->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return VendorDocumentType::select(['id', 'name', 'description'])
            ->orderBy('name', 'asc')->get();
    }
}
