<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorInvitation;
use App\Http\Requests\VendorInvitationRequest;
use App\Mail\VendorInvitationMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class VendorInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorInvitation::with('user')
            ->when($request->keyword, function($q) use ($request) {
                return $q->where('email', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('name', 'LIKE', '%'.$request->keyword.'%')
                    ->orWhere('company_name', 'LIKE', '%'.$request->keyword.'%');
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
    public function store(VendorInvitationRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $input['invitation_url'] = URL::temporarySignedRoute('create-vendor', now()->addDays(7));
        $invitation = VendorInvitation::create($input);

        Mail::to($request->email, $request->name)
            ->cc('bagas@lamsolusi.com')
            ->queue(new VendorInvitationMail($invitation));

        return $invitation;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VendorInvitation $vendorInvitation)
    {
        return new VendorInvitationMail($vendorInvitation);
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
