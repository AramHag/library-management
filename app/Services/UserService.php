<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{


    /**
     * list all users with optional filters.
     * 
     * @param int $perPage.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function listUsers(int $perPage)
    {
        $usersQuery = User::query();
        $usersQuery->select(['name', 'email']);

        return $usersQuery->paginate($perPage);
    }


    /**
     * Create new user with given data.
     * 
     * @param array $data the data of new user
     * @return array $user 
     */
    public function storeUser(array $data)
    {
        DB::beginTransaction();

        try {
            $user = User::create($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Shwo the data of a specific user by id.
     * 
     * @param int $id the id of the user
     * @return array $user the data of the user.
     */

    public function showUser(int $id)
    {
        return User::findOrFail($id);
    }

    /**
     * update the data of specified user.
     * 
     * @param array $data update with the given data.
     * @param int $id.
     * 
     * @return App\Model\Uesr $user.
     */

    public function updateUser(array $data, int $id)
    {
        $user = User::findOrFail($id);

        $user->update(array_filter($data));

        return $user;
    }

    /**
     * delete a specified user  from storage.
     * 
     * @param int $id
     */

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }
}
