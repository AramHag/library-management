<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\ApiResponseService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @var BookService
     */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    /**
     * List all users with optional filters.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) 
    {

        $perPage = $request->input('per_page', 15); //Default is 15 if not provided.

        $users = $this->userService->listUsers($perPage);

        return ApiResponseService::paginated($users, 'All users retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->storeUser($data);

        return ApiResponseService::success($user, 'New user created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->userService->showUser($id);

        return ApiResponseService::success($user, 'The user is returned', 200);
    }

    /**
     * Update the specified user in storage.
     * 
     * @param UpdateUserRequest $request
     * @param int $id the id of updated user.
     * 
     * @return Illuminate\Http\JsonResponse JsonResponse.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        //validate request data.
        $data = $request->validated();

        $user = $this->userService->updateUser($data, $id);

        return ApiResponseService::success($user, 'The is successfully updated', 200);
    }

    /**
     * Remove the specified user from storage.
     * 
     * @param int $id.
     * @return Illuminate\Http\JsonResonse JosnResponse.
     */
    public function destroy(int $id)
    {
        $this->userService->deleteUser($id);
        return ApiResponseService::success(null, 'User deleted successfully');
    }
}
