<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoiceSubmissionReview;
use App\Http\Requests\InvoiceSubmissionReviewRequest;

class InvoiceSubmissionReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return InvoiceSubmissionReview::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceSubmissionReviewRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return InvoiceSubmissionReview::create($input);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceSubmissionReviewRequest $request, InvoiceSubmissionReview $invoiceSubmissionReview)
    {
        $invoiceSubmissionReview->update($request->all());
        return $invoiceSubmissionReview;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceSubmissionReview $invoiceSubmissionReview)
    {
        if ($invoiceSubmissionReview->status == 1) {
            return response(['message' => 'Failed to delete data. Data has been submitted.'], 500);
        }

        $invoiceSubmissionReview->delete();
        return ['message' => 'Data has been deleted'];
    }
}
