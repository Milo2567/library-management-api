<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Retrieve all books
     * GET: /api/books
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(){
        return $this->Ok(Book::all(), "Books has been retrieved");
    }

    /**
     * Retrieve a specific book based on ID
     * GET: /api/books/{book}
     * @param \App\Models\Book $book
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Book $book){
        return $this->Ok($book, "Book has been retrieved!");
    }


    /**
     * Create a book based on user input.
     * POST: /api/books
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = validator($request->all(), [
            "title" => "required|string|max:255",
            "summary" => "required|string",
            "date_published" => "sometimes|date"
        ]);

        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $book = Book::create($validator->validated());

        return $this->Created($book, "Book has been created!");
    }

    /**
     * Update a book using ID and user input.
     * PATCH: /api/books/{book}
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Book $book
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $validator = validator($request->all(), [
            "title" => "required|string|max:255",
            "summary" => "required|string",
            "date_published" => "sometimes|date"
        ]);
        
        if($validator->fails()){
            return $this->BadRequest($validator);
        }

        $book = Book::update($validator->validated());

        return $this->Ok($book, "Book has been updated!");
    }
    
    /**
     * Deletes a book by ID
     * DELETE: /api/books/{book}
     * @param \App\Models\Book $book
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book){
        $book->delete();

        return $this->Ok(null, "Book has been deleted!");
    }
}
