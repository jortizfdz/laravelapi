<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EditorialResource;
use App\Http\Resources\EditorialListResource;
use App\Models\Editorial;
use Illuminate\Support\Facades\Validator;

class EditorialController extends Controller
{
    public function __construct(){
      $this->middleware(['auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return EditorialResource::collection(Editorial::with('address')->paginate());
    }

    public function list(){
      return EditorialListResource::collection(Editorial::select(['id','name'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
           'name' => 'required',
           'address_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        Editorial::create($request->only(['name','address_id']));
        return response('Record has been created.',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return new EditorialResource(Editorial::with(['address'])->where('id',$id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validator = Validator::make($request->all(), [
           'name' => 'required',
           'address_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        $editorial = Editorial::findOrFail($id);
        $editorial->update($request->only(['name','address_id']));
        return response('Record has been updated.',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $editorial = Editorial::findOrFail($id);
      if($editorial->address->isNotEmpty()){
        return response("You can't delete this record.", 401);
      }else{
        $editorial->delete();
        return response('Record has been deleted.', 200);
      }
    }
}
