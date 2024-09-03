<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\ApiResponseService;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{

        /**
     * @var BookService
     */
    protected $bookService;

    /**
     * BookController constructor.
     *
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the books.
     * 
     * @param Request $request
     * @return Illumiante\Http\JsonResponse The JsonResponse.
     */
    public function index(Request $request)
    {
        // return $request;
        $filters = $request->only(['author']);
        $perPage = $request->input('per_page', 15); 

        $books =  $this->bookService->listBooks($filters, $perPage);
        return ApiResponseService::success($books, 'List of books returned successfully', 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        $book = $this->bookService->storeBorrowRecord($data);

        return ApiResponseService::success($book, 'New book created successfully', 201);
    }

    /**
     * Display the specified book.
     * 
     * @param int $id.
     * @return \Illuminate\Http\JsonResponse the json response of a book.
     */
    public function show(int $id)
    {
        $book = $this->bookService->showBook($id);

        return ApiResponseService::success($book, 'The book is retrieved successfully' ,200);

    }

    /**
     * Update the specified book in storage.
     * 
     * @param UpdateBookRequest $request.
     * @param int $id.
     * @return \Illuminate\Http\JsonResponse the json response.
     */
    public function update(UpdateBookRequest $request, int $id)
    {
        $data = $request->validated();

        $book = $this->bookService->updateBook($data, $id);

        return ApiResponseService::success($book, 'The book is updated successfully', 200);
    }

    /**
     * Remove the specified book from storage.
     * 
     * @param int $id.
     * @return \Illuminate\Http\JsonResponse json reponse.
     */
    public function destroy(int $id)
    {
        $this->bookService->deleteBook($id);

        return ApiResponseService::success(null, 'Book Deleted Successfully', 200);
    }
}
