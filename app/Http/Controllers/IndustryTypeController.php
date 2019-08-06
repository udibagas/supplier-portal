<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndustryType;
use App\Http\Requests\IndustryTypeRequest;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return IndustryType::when($request->keyword, function($q) use ($request) {
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
    public function store(IndustryTypeRequest $request)
    {
        return IndustryType::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IndustryTypeRequest $request, IndustryType $industryType)
    {
        $industryType->update($request->all());
        return $industryType;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(IndustryType $industryType)
    {
        return $industryType->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return IndustryType::select(['id', 'name'])
            ->orderBy('name', 'asc')->get();
    }
}
