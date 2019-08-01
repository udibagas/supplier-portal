<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuotationRequestAssignment;
use App\Http\Requests\QuotationRequestAssignmentRequest;

class QuotationRequestAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return QuotationRequestAssignment::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequestAssignmentRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $quotationRequestAssignment = QuotationRequestAssignment::create($input);
        // TODO: if submitted then send email to vendors and update quotation request
        return $quotationRequestAssignment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequestAssignmentRequest $request, QuotationRequestAssignment $quotationRequestAssignment)
    {
        $quotationRequestAssignment->update($request->all());
        // TODO: if submitted then send email to vendors and update quotation request
        return $quotationRequestAssignment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuotationRequestAssignment $quotationRequestAssignment)
    {
        if ($quotationRequestAssignment->status == 1) {
            return response(['message' => 'Failed to delete data. Data has been submitted.'], 500);
        }

        $quotationRequestAssignment->delete();
        return ['message' => 'Data has been deleted'];
    }
}
