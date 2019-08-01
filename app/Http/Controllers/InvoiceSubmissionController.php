<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoiceSubmission;
use App\Http\Requests\InvoiceSubmissionRequest;

class InvoiceSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return InvoiceSubmission::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return InvoiceSubmission::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceSubmission $invoiceSubmission)
    {
        return $invoiceSubmission;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceSubmissionRequest $request, InvoiceSubmission $invoiceSubmission)
    {
        $invoiceSubmission->update($request->all());
        return $invoiceSubmission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceSubmission $invoiceSubmission)
    {
        if ($invoiceSubmission->status == 1) {
            return response(['message' => 'Failed to delete data. Data has been submitted.'], 500);
        }

        return $invoiceSubmission->delete();
        return ['message' => 'Data has been deleted'];
    }
}
