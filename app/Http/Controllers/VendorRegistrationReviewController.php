<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorRegistrationReview;
use App\Http\Requests\VendorRegistrationReviewRequest;

class VendorRegistrationReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return VendorRegistrationReview::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRegistrationReviewRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return VendorRegistrationReview::create($input);
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
    public function update(VendorRegistrationReviewRequest $request, VendorRegistrationReview $vendorRegistrationReview)
    {
        $vendorRegistrationReview->update($request->all());
        return $vendorRegistrationReview;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorRegistrationReview $vendorRegistrationReview)
    {
        $vendorRegistrationReview->delete();
        return ['message' => 'Data has been deleted'];
    }
}
