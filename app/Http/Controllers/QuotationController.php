<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Http\Requests\QuotationRequest;
use Illuminate\Support\Facades\DB;

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
        $quotation = DB::transaction(function () use ($request) {
            $quotation = Quotation::create(array_merge($request->all(), [
                'user_id' => $request->user()->id,
                'vendor_id' => $request->user()->vendor_id,
            ]));

            $quotation->items()->createMany($request->items);

            return $quotation;
        });

        return ['message' => 'Data has been saved!', 'data' => $quotation];
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
            DB::transaction(function () use ($request, $quotation) {
                DB::table('quotations')
                    ->where('id', $quotation->id)
                    ->update([
                        'quotation_number' => $request->quotation_number,
                        'currency' => $request->currency,
                        'term_of_payment' => $request->term_of_payment,
                        'inco_term' => $request->inco_term,
                    ]);

                // delete all item first
                DB::table('quotation_items')
                    ->where('quotation_id', $quotation->id)
                    ->delete();

                // add new item
                DB::table('quotation_items')->insert(
                    array_map(function ($item) use ($quotation) {
                        $item['quotation_id'] = $quotation->id;
                        return $item;
                    }, $request->items)
                );
            });
        } catch (\Exception $e) {
            return response(['message' => 'Failed to save data. ' . $e->getMessage()], 500);
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
