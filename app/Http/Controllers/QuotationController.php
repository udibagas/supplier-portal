<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Http\Requests\QuotationRequest;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Quotation::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $id = DB::table('quotation_requests')->insertGetId([
                    'user_id' => $request->user()->id,
                    'department_id' => $request->department_id,
                    'subject' => $request->subject
                ]);

                DB::table('quotation_request_items')->insert(
                    array_map(function($item) use ($id) {
                        $item['quotation_id'] = $id;
                        return $item;
                    }, $request->items)
                );
            });
        } catch (\Exception $e) {
            return response(['message' => 'Failed to save data. '. $e->getMessage()], 500);
        }

        return ['message' => 'Data has been saved!'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        return $quotation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequest $request, Quotation $quotation)
    {
        try {
            DB::transaction(function () use ($request, $quotationRequest) {
                DB::table('quotation_requests')
                    ->where('id', $quotationRequest->id)
                    ->update([
                        'department_id' => $request->department_id,
                        'subject' => $request->subject
                    ]);

                // delete all item first
                DB::table('quotation_request_items')
                    ->where('quotation_request_id', $quotationRequest->id)
                    ->delete();

                // add new item
                DB::table('quotation_request_items')->insert(
                    array_map(function($item) use ($quotationRequest) {
                        $item['quotation_id'] = $quotationRequest->id;
                        return $item;
                    }, $request->items)
                );
            });
        } catch (\Exception $e) {
            return response(['message' => 'Failed to save data. '. $e->getMessage()], 500);
        }

        return ['message' => 'Data has been saved!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        // TODO: check status first
        $quotation->delete();
        return ['message' => 'Data has been deleted'];
    }
}
