<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentTerm;
use App\Http\Requests\PaymentTermRequest;

class PaymentTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PaymentTerm::when($request->keyword, function($q) use ($request) {
                return $q->where('description', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('code', 'LIKE', '%'.$request->keyword.'%');
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
    public function store(PaymentTermRequest $request)
    {
        return PaymentTerm::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentTermRequest $request, PaymentTerm $paymentTerm)
    {
        $paymentTerm->update($request->all());
        return $paymentTerm;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTerm $paymentTerm)
    {
        $paymentTerm->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return PaymentTerm::select(['id', 'code', 'description', 'days'])
            ->orderBy('code', 'asc')->get();
    }
}
