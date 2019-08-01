<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuotationRequestRequest;
use App\QuotationRequest;

class QuotationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return QuotationRequest::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequestRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return QuotationRequest::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(QuotationRequest $quotationRequest)
    {
        return $quotationRequest;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequestRequest $request, QuotationRequest $quotationRequest)
    {
        $quotationRequest->update($request->all());
        return $quotationRequest;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuotationRequest $quotationRequest)
    {
        // TODO : check status first
        $quotationRequest->delete();
        return ['message' => 'Data has been deleted'];
    }
}
