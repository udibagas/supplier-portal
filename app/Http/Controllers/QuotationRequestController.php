<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuotationRequestRequest;
use App\QuotationRequest;
use Illuminate\Support\Facades\DB;

class QuotationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return QuotationRequest::with(['user', 'department', 'items'])
            ->when($request->keyword, function($q) use ($request) {
                return $q->where('subect', 'LIKE', '%'.$request->keyword.'%');
            })
            ->orderBy($request->sort, $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequestRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $id = DB::table('quotation_requests')->insertGetId([
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $request->user()->id,
                    'department_id' => $request->department_id,
                    'subject' => $request->subject,
                    'status' => $request->status
                ]);

                DB::table('quotation_request_items')->insert(
                    array_map(function($item) use ($id) {
                        $item['created_at'] = $item['updated_at'] = now();
                        $item['quotation_request_id'] = $id;
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
        try {
            DB::transaction(function () use ($request, $quotationRequest) {
                DB::table('quotation_requests')
                    ->where('id', $quotationRequest->id)
                    ->update([
                        'updated_at' => now(),
                        'department_id' => $request->department_id,
                        'subject' => $request->subject,
                        'status' => $request->status
                    ]);

                // delete all item first
                DB::table('quotation_request_items')
                    ->where('quotation_request_id', $quotationRequest->id)
                    ->delete();

                // add new item
                DB::table('quotation_request_items')->insert(
                    array_map(function($item) use ($quotationRequest) {
                        // assign null when not available
                        unset($item['id']);
                        unset($item['attachment']);
                        $item['created_at'] = $item['updated_at'] = now();
                        $item['quotation_request_id'] = $quotationRequest->id;
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
    public function destroy(QuotationRequest $quotationRequest)
    {
        // TODO : check status first
        $quotationRequest->delete();
        return ['message' => 'Data has been deleted'];
    }
}
