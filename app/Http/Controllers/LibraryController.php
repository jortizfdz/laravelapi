<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LibraryResource;
use App\Http\Resources\LibraryListResource;
use App\Models\Library;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    public function __construct(){
      $this->middleware(['auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return LibraryResource::collection(Library::with(['address','books'])->paginate());
    }

    public function list(){
      return LibraryListResource::collection(Library::select(['id','name'])->get());
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
        Library::create($request->only(['name','address_id']));
        return response('Record has been created.',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return new LibraryResource(Library::with(['address','books'])->where('id',$id)->first());
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
        $library = Library::findOrFail($id);
        $library->update($request->only(['name','address_id']));
        return response('Record has been updated.',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $library = Library::findOrFail($id);
      if($library->books->isNotEmpty()){
        return response("You can't delete this record.", 401);
      }else{
        $library->delete();
        return response('Record has been deleted.', 200);
      }
    }
}
