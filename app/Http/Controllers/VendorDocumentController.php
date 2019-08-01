<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorDocument;
use App\Http\Requests\VendorDocumentRequest;

class VendorDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorDocument::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorDocumentRequest $request)
    {
        return VendorDocument::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorDocumentRequest $request, VendorDocument $vendorDocument)
    {
        $vendorDocument->update($request->all());
        return $vendorDocument;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorDocument $vendorDocument)
    {
        $vendorDocument->delete();
        if (file_exists($vendorDocument->file_path)) {
            unlink($vendorDocument->file_path);
        }

        return ['message' => 'Data has been deleted'];
    }
}
