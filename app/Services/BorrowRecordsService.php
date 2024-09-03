<?php

namespace App\Services;

use App\Models\BorrowRecord;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowRecordsService
{
    /**
     * return the list of borrowed books.
     * 
     * @param int $perPage.
     * @return $records the list of all borrowed books 
     */
    public function listRecords(int $perPage)
    {
        $records = BorrowRecord::paginate($perPage);
        return $records;
    }

    /**
     * Store new record for borrow books
     * 
     * @param array $data.
     * @return @record.
     */
    public function storeBorrowRecord(array $data)
    {
        DB::beginTransaction();
        try {
            $borrowed_at = Carbon::createFromFormat('Y-m-d', $data['borrowed_at']);
            $data['due_date'] = date($borrowed_at->addDays(14));
            $record = BorrowRecord::create($data);
            DB::commit();
            return $record;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    /**
     * show a record of borrowing book
     * 
     * @param int $id
     * @return BorrowRecord $borrowRecord.
     */
    public function getBorrowRecord(int $id)
    {

        return BorrowRecord::findOrFail($id);
    }

    /**
     * update a record of borrowing book
     * 
     * @param int $id
     * @param  array $data.
     * @return BorrowRecord $borrowRecrod
     */
    public function updateBorrowRecord(array $data, int $id)
    {
        $borrowed_at = Carbon::createFromFormat('Y-m-d', $data['borrowed_at']);
        $data['due_date'] = date($borrowed_at->addDays(14));
        $data['due_date'];
        $borrowRecord = BorrowRecord::findOrFail($id);
        $borrowRecord->update(array_filter($data));
        return $borrowRecord;
    }

    /**
     * delete a record of borrowed book
     * 
     * @param int $id
     */

    public function deleteBorrowRecord(int $id) 
    {
        $record = BorrowRecord::findOrFail($id);
        $record->delete();
    }
}
