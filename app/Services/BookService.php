<?php

namespace App\Services;

use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;

class BookService
{

    /**
     * return list of all books.
     * 
     * @param array $filters.
     * 
     * @return $books
     */
    public function listBooks(array $filters, int $perPage)
    {

        $booksQuery = Book::query();

        if (isset($filters['author'])) {
            // return $filters['author'];
            $booksQuery->where('author', $filters['author']);
        }

        $books =  $booksQuery->paginate($perPage);

        return $books;
    }

    /**
     * Store new books with given data
     * 
     * @param array $data  given to store new book
     * @return  $book(New book).
     */
    public function storeBook(array $data)
    {
        DB::beginTransaction();
        try {
            $book = Book::create($data);

            DB::commit();

            return $book;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * retrieve a spcific book by id.
     * 
     * @param int $id.
     * @return $book.
     */

    public function showBook(int $id)
    {
        $book = Book::findOrFail($id);
        return $book;
    }

    /**
     * udpate book with given data.
     * 
     * @param array $data.
     * @param int $id.
     * @return Book $book.
     */

    public function updateBook(array $data, int $id)
    {
        $book = Book::findOrFail($id);

        $book->update(array_filter($data));

        return $book;
    }

    /**
     * delete book with given ID
     * 
     * @param int $id.
     * 
     */
    public function deleteBook(int $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }
}
