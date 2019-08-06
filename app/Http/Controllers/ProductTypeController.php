<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductType;
use App\Http\Requests\ProductTypeRequest;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ProductType::when($request->keyword, function($q) use ($request) {
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
    public function store(ProductTypeRequest $request)
    {
        return ProductType::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductTypeRequest $request, ProductType $productType)
    {
        $productType->update($request->all());
        return $productType;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function getList()
    {
        return ProductType::select(['id', 'name'])
            ->orderBy('name', 'asc')->get();
    }
}
