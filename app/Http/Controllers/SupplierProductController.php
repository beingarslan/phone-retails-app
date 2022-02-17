<?php

namespace App\Http\Controllers;

use App\Models\SupplierProduct;
use App\Http\Requests\StoreSupplierProductRequest;
use App\Http\Requests\UpdateSupplierProductRequest;

class SupplierProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupplierProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierProduct  $supplierProduct
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierProduct  $supplierProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupplierProductRequest  $request
     * @param  \App\Models\SupplierProduct  $supplierProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierProductRequest $request, SupplierProduct $supplierProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierProduct  $supplierProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierProduct $supplierProduct)
    {
        //
    }
}
