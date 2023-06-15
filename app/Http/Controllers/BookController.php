<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookListResource;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function __construct(){
      $this->middleware(['auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return BookResource::collection(Book::with(['editorial','author'])->paginate());
    }

    public function list(){
      return BookListResource::collection(Book::select(['id','name'])->get());
    }
    public function search(Request $request){
      $query = Book::query();
      if($request->name!=null){
        $query->where('name','like','%'.$request->name.'%');
      }
      if($request->editorial_id!=null){
        $query->where('editorial_id',$request->editorial_id);
      }
      if($request->author_id!=null){
        $query->where('author_id',$request->author_id);
      }
      $model = $query->with('author','editorial')->paginate();
      return BookResource::collection($model);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
           'name' => 'required',
           'description' => 'required',
           'page_numbers' => 'required|integer',
           'editorial_id' => 'required|integer',
           'author_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        Book::create($request->only(['name','description','page_numbers','editorial_id','author_id']));
        return response('Record has been created.',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return new BookResource(Book::with(['editorial','author'])->where('id',$id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $validator = Validator::make($request->all(), [
           'name' => 'required',
           'description' => 'required',
           'page_numbers' => 'required|integer',
           'editorial_id' => 'required|integer',
           'author_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
              'message'   => 'Error on validate',
              'data'=> $validator->errors()
            ], 400);
        }
        $book = Book::findOrFail($id);
        $book->update($request->only(['name','description','page_numbers','editorial_id','author_id']));
        return response('Record has been updated.',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $book = Author::findOrFail($id);
      if($book->libraries->isNotEmpty()){
        return response("You can't delete this record.", 401);
      }else{
        $book->delete();
        return response('Record has been deleted.', 200);
      }
    }
}
