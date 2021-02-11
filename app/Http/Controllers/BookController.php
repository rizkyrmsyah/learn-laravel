<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;

use App\Http\Requests\BookRequest;

use App\Http\Resources\BookResource;

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
        
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request, Category $category, Author $author)
    {
        $validated = $request->validated();
        
        $categoryCheck = $category->checkCategory($request->category_id);
        if(!$categoryCheck){
            return response()->json(["message" => "Kategori tidak ditemukan"], 422);
        }
        
        $authorCheck = $author->checkAuthor($request->author_id);
        if(!$authorCheck){
            return response()->json(["message" => "Penulis tidak ditemukan"], 422);
        }

        $checkIfExisting = Book::where('category_id',$request->category_id)
            ->where('author_id',$request->author_id)
            ->where('title', $request->title)
            ->first();
        
        if($checkIfExisting){
            return response()->json(["message" => "Buku sudah ada"], 422);
        }

        Book::insert($request->all()+[
            "id" => Uuid::uuid4()
        ]);

        return response()->json(["message" => "Tambah buku berhasil"], 200);
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
        $book->delete();
        
        return response()->json(["message" => "Hapus buku berhasil"], 200);
    }
}
