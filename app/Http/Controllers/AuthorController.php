<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorListResource;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function __construct(){
      $this->middleware(['auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return AuthorResource::collection(Author::with('editorial')->paginate());
    }

    public function list(){
      return AuthorListResource::collection(Author::select(['id','name'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
           'name' => 'required',
           'last_name' => 'required',
           'email' => 'required|unique:authors',
           'phone' => 'required',
           'editorial_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        Author::create($request->only(['name','last_name','email','phone','editorial_id']));
        return response('Record has been created.',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return new AuthorResource(Author::with(['editorial'])->where('id',$id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validator = Validator::make($request->all(), [
           'name' => 'required',
           'last_name' => 'required',
           'email' => 'required|unique:authors',
           'phone' => 'required',
           'editorial_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        $author = Author::findOrFail($id);
        $author->update($request->only(['name','last_name','email','phone','editorial_id']));
        return response('Record has been updated.',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $author = Author::findOrFail($id);
      if($author->books->isNotEmpty()){
        return response("You can't delete this record.", 401);
      }else{
        $author->delete();
        return response('Record has been deleted.', 200);
      }
    }
}
