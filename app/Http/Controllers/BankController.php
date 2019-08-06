<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\Http\Requests\BankRequest;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Bank::when($request->keyword, function($q) use ($request) {
                return $q->where('code', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('name', 'LIKE', '%'.$request->keyword.'%');
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
    public function store(BankRequest $request)
    {
        return Bank::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, Bank $bank)
    {
        $bank->update($request->all());
        return $bank;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return Bank::select(['id', 'code', 'name'])
            ->orderBy('code', 'asc')->get();
    }
}
