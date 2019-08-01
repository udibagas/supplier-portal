<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountGroup;
use App\Http\Requests\AccountGroupRequest;

class AccountGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return AccountGroup::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return AccountGroup::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountGroupRequest $request, AccountGroup $accountGroup)
    {
        $accountGroup->update($request->all());
        return $accountGroup;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountGroup $accountGroup)
    {
        $accountGroup->delete();
        return ['message' => 'Data has been deleted'];
    }
}
