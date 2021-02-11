<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Ramsey\Uuid\Uuid;

use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(10);
        
        return response()->json([
            "code" => 200,
            "message" => "success",
            "result" => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request, Category $category)
    {
        $validated = $request->validated();
        
        $categoryCheck = Category::where('id', $request->category_id)->first();
        if(!$categoryCheck){
            return response()->json([
                "code" => 404,
                "message" => "Kategori tidak ditemukan"
            ],404);
        }
        
        $authorCheck = Author::where('id', $request->author_id)->first();
        if(!$authorCheck){
            return response()->json([
                "code" => 404,
                "message" => "Penulis tidak ditemukan"
            ],404);
        }

        $checkIfExisting = Book::where('category_id',$request->category_id)
            ->where('author_id',$request->author_id)
            ->where('title', $request->title)
            ->first();
        
        if($checkIfExisting){
            return response()->json([
                "code" => 422,
                "message" => "Buku sudah ada"
            ],422);
        }

        Book::insert($request->all()+[
            "id" => Uuid::uuid4()
        ]);

        return response()->json([
            "code" => 200,
            "message" => "Tambah buku berhasil"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
