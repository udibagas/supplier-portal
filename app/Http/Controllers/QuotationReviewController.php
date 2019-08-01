<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuotationReview;
use App\Http\Requests\QuotationReviewRequest;

class QuotationReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return QuotationReview::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationReviewRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return QuotationReview::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationReviewRequest $request, QuotationReview $quotationReview)
    {
        $quotationReview->update($request->all());
        return $quotationReview;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuotationReview $quotationReview)
    {
        // TODO: check status first
        $quotationReview->delete();
        return ['message' => 'Data has been deleted'];
    }
}
