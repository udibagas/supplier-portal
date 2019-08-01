<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorInvitation;
use App\Http\Requests\VendorInvitationRequest;

class VendorInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorInvitation::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorInvitationRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return VendorInvitation::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorInvitationRequest $request, VendorInvitation $vendorInvitation)
    {
        $vendorInvitation->update($request->all());
        return $vendorInvitation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorInvitation $vendorInvitation)
    {
        $vendorInvitation->delete();
        return ['message' => 'Data has been deleted'];
    }
}
