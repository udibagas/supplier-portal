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
        return VendorDocument::when($request->user()->isVendor(), function($q) {
                return $q->where('vendor_id', auth()->user()->vendor_id);
            })->when($request->keyword, function($q) use ($request) {
                return $q->where('name', 'LIKE', '%'.$request->keyword.'%');
            })->when($request->vendor_id, function($q) use ($request) {
                return $q->whereIn('vendor_id', $request->vendor_id);
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

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileName = time().$file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if (!in_array(strtolower($extension), ['pdf', 'png', 'jpeg', 'jpg', 'bmp'])) {
            return response(['message' => 'File extension not permitted'], 500);
        }

        try {
            $file->move('files/', $fileName);
        } catch (\Exception $e) {
            return response(['message' => 'Failed to move file'], 500);
        }

        return [
            'success' => true,
            'file' => 'files/'.$fileName,
            'message' => 'File has been uploaded!'
        ];
    }

    public function deleteFile(Request $request)
    {
        $doc = VendorDocument::where('file_path', $request->file_path)->first();

        if ($doc && file_exists($doc->file_path))
        {
            try {
                unlink($doc->file_path);
            } catch (\Exception $e) {
                return response(['message' => 'Failed to delete file'], 500);
            }

            return ['message' => 'File has been deleted!'];
        }

        return response(['message' => 'File not found!'], 404);
    }
}
