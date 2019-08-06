<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PartnershipType;
use App\Http\Requests\PartnershipTypeRequest;

class PartnershipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PartnershipType::when($request->keyword, function($q) use ($request) {
                return $q->where('description', 'LIKE', '%'.$request->keyword.'%')
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
    public function store(PartnershipTypeRequest $request)
    {
        return PartnershipType::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PartnershipTypeRequest $request, PartnershipType $partnershipType)
    {
        $partnershipType->update($request->all());
        return $partnershipType;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnershipType $partnershipType)
    {
        $partnershipType->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return PartnershipType::select(['id', 'name'])
            ->orderBy('name', 'asc')->get();
    }
}
