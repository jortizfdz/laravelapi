<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function __construct(){
      $this->middleware(['auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AddressResource::collection(Address::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
           'exterior_number' => 'required',
           'interior_number' => 'required',
           'zip' => 'required',
           'street_name' => 'required',
           'reference' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        Address::create($request->only(['exterior_number','interior_number','zip','street_name','reference']));
        return response('Record has been created.',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new AddressResource(Address::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validator = Validator::make($request->all(), [
           'exterior_number' => 'required',
           'interior_number' => 'required',
           'zip' => 'required',
           'street_name' => 'required',
           'reference' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
      $address = Address::findOrFail($id);
      $address->update($request->only(['exterior_number','interior_number','zip','street_name','reference']));
      return response('Record has been updated.',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Address::findOrFail($id);
        if($address->editorials->isNotEmpty() || $address->libraries->isNotEmpty()){
          return response("You can't delete this record.", 401);
        }else{
          $address->delete();
          return response('Record has been deleted.', 200);
        }
    }
}
