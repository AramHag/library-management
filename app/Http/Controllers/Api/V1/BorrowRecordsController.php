<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateBorrowRecordRequest;
use App\Services\ApiResponseService;
use App\Services\BorrowRecordsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowRecordsController extends Controller
{

    /**
     * @var BorrowRecordsService
     */
    protected $borrowRecordsService;

    /**
     * BorrowRecordsController constructor
     * 
     * @param BorrowRecordsService $borrowRecordsService.
     */
    public function __construct(BorrowRecordsService $borrowRecordsService)
    {
        $this->borrowRecordsService = $borrowRecordsService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 15);
        $records = $this->borrowRecordsService->listRecords($perPage);
        return ApiResponseService::success($records, 'All records of borrowed books are retrieved', 200);
    }

    /**
     * Store a newly created BorrowRecord in storage.
     * 
     * @param StoreRecordRequest $request.
     * @return \Illuminate\Http\JsonResponse json Response
     */
    public function store(StoreRecordRequest $request)
    {
        $data = $request->validated();
        $record = $this->borrowRecordsService->storeBorrowRecord($data);

        return ApiResponseService::success($record, 'The book is successfully borrowed');
    }

    /**
     * Display the specified borrow record.
     * 
     * @param int $id.
     * 
     * @return \Illuminate\Http\JsonResponse json response.
     */
    public function show(int $id)
    {
        $borrowRecord = $this->borrowRecordsService->getBorrowRecord($id);

        return ApiResponseService::success($borrowRecord, 'The record is retrieved successfully', 200);
    }


    /**
     * Update the specified borrow record in storage.
     * @param int $id
     * @param UpdateBorrowRecordRequest $request
     * @return \Illuminate\Http\JsonResponse JsonResponse 
     */
    public function update(UpdateBorrowRecordRequest $request, int $id)
    {
        $data = $request->validated();

        $borrowRecord = $this->borrowRecordsService->updateBorrowRecord($data, $id);

        return ApiResponseService::success($borrowRecord, 'The record is updated successfully');
    }

    /**
     * Remove the specified borrow record from storage.
     * 
     * @param int id
     */
    public function destroy(int $id)
    {
        $this->borrowRecordsService->deleteBorrowRecord($id);

        return ApiResponseService::success(null, 'The Record of borrowed book is deleted', 200);
    }
}
