<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuotationRequestItem;

class QuotationRequestItemController extends Controller
{
    // cuma buat validasi aja
    public function store(QuotationRequestItemRequest $request)
    {
        return $request;
    }

    public function destroy(QuotationRequestItem $quotationRequestItem)
    {
        $quotationRequestItem->delete();

        if ($quotationRequestItem->attachment && file_exists($quotationRequestItem->attachment)) {
            unlink($quotationRequestItem->attachment);
        }

        return ['message' => 'Data has been deleted.'];
    }

    public function uploadAttachment(Request $request)
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
            'file' => 'files/'.$fileName,
            'message' => 'File has been uploaded!'
        ];
    }

    public function deleteAttachment(Request $request)
    {
        $item = QuotationRequestItem::where('attachment', $request->attachment)->first();

        if ($item && file_exists($item->attachment))
        {
            try {
                unlink($item->attachment);
            } catch (\Exception $e) {
                return response(['message' => 'Failed to delete file. '. $e->getMessage()], 500);
            }

            return ['message' => 'File has been deleted!'];
        }

        return response(['message' => 'File not found!'], 404);
    }
}
