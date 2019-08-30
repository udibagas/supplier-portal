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
        return InvoiceSubmission::selectRaw('
            invoice_submissions.*,
            vendors.name AS vendor,
            payment_terms.description AS payment_term,
            wht_code.VCH_Description AS wht_code,
            wht_type.VCH_Description AS wht_type
        ')
            ->join('payment_terms', 'payment_terms.id', '=', 'invoice_submissions.payment_term_id')
            ->join('vendors', 'vendors.id', '=', 'invoice_submissions.vendor_id')
            ->join('wht_type', 'wht_type.VCH_whtType', '=', 'invoice_submissions.wht_type_id')
            ->join('wht_code', 'wht_code.id', '=', 'invoice_submissions.wht_code_id')
            ->when($request->keyword, function($q) use ($request) {
                return $q->where('invoice_number', 'LIKE', '%'.$request->keyword.'%')
                         ->orWhere('faktur_number', 'LIKE', '%'.$request->keyword.'%');
            })
            ->when($request->vendor_id, function($q) use ($request) {
                return $q->where('vendor_id', $request->vendor_id);
            })->orderBy($request->sort, $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceSubmissionRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $input['vendor_id'] = $request->user()->vendor_id;
        $invoiceSubmission = InvoiceSubmission::create($input);
        $invoiceSubmission->items()->createMany($request->items);
        $invoiceSubmission->attachments()->createMany($request->attachments);
        return $invoiceSubmission;
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
        $invoiceSubmission->items()->delete();
        $invoiceSubmission->attachments()->delete();
        $invoiceSubmission->items()->createMany($request->items);
        $invoiceSubmission->attachments()->createMany($request->attachments);
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

        $invoiceSubmission->delete();
        $invoiceSubmission->items()->delete();
        $invoiceSubmission->attachments()->delete();
        return ['message' => 'Data has been deleted'];
    }
}
