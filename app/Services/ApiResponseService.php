<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseService
{

    /**
     * return successful Json Responce.
     *
     * @param mixed $data the data need to return with the reponse.
     * @param string $message success message string.
     * @param int the status of HTTP status.
     * @return \Illuminate\Http\JsonResponse a Json Response.
     */
    public static function success($data = null, $message = 'Operation Successed', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => trans($message),
            'data' => $data,
        ], $status);
    }


    /**
     * Return Failed Json Response.
     * 
     * @param mixed $data the data need to return with response.
     * @param string $message an error message.
     * @param int $status The status of Http Response.
     * @return \Illuminate\Http\JsonResponse a Json Response.
     */
    public static function error($data = null, $message = 'Operation Failed', $status = 404)
    {
        return response()->json([
            'status' => 'Error',
            'message' => trans($message),
            'data' => $data,
        ], $status);
    }



    /**
     * Return a paginated JSON Response.
     * 
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator The paginator instance.
     * @param string $message The success message.
     * @param int $status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse The JSON Response.
     */
    public static function paginated(LengthAwarePaginator $paginator, $message = 'Operation Successed', $status = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => trans($message),
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'count' => $paginator->count(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
            ],
        ], $status);
    }
}
