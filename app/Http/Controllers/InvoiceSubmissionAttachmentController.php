<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoiceSubmissionAttachment;

class InvoiceSubmissionAttachmentController extends Controller
{
    public function uploadFile(Request $request)
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
            'file_path' => 'files/'.$fileName,
            'message' => 'File has been uploaded!',
            'type' => $request->type
        ];
    }

    public function deleteFile(Request $request)
    {
        $doc = InvoiceSubmissionAttachment::where('file_path', $request->file_path)->first();

        if ($doc && file_exists($doc->file_path))
        {
            try {
                unlink($doc->file_path);
            } catch (\Exception $e) {
                return response(['message' => 'Failed to delete file. ' . $e->getMessage()], 500);
            }

            return ['message' => 'File has been deleted!'];
        }

        return response(['message' => 'File not found!'], 404);
    }
}
