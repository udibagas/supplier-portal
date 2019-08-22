<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use App\Http\Requests\VendorRequest;
use App\Mail\VendorRegistrationNotification;
use App\Mail\VendorRegistrationSubmission;
use Illuminate\Support\Facades\Mail;
use App\User;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Vendor::when($request->keyword, function($q) use ($request) {
                return $q->where('vendors.name', 'LIKE', '%'.$request->keyword.'%');
            })
            ->orderBy($request->sort, $request->order == 'ascending' ? 'asc' : 'desc')
            ->paginate($request->pageSize);
    }

    public function create()
    {
        return view('vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        return Vendor::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return $vendor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->all());
        return $vendor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        return $vendor->delete();
        // TODO: delete all document add trx
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return Vendor::select(['id', 'name'])
            ->orderBy('name', 'asc')->get();
    }

    public function notify(Vendor $vendor)
    {
        Mail::to($vendor->user)->queue(new VendorRegistrationNotification($vendor));
        Mail::to('bagas@lamsolusi.com')->queue(new VendorRegistrationSubmission($vendor));
        return ['message' => 'OK'];
    }

    public function getByUser(User $user)
    {
        return $user->vendor;
    }
}
