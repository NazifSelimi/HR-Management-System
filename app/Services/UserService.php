<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class UserService
{

    public function getEmployees()
    {
        return User::query()->where("role_id", 2)->get();
    }
    public function create($data)
    {
        DB::beginTransaction();
        $user = new User($data);
        $user->save();
        if($user->id){
            DB::commit();
            return true;
        }else{
            DB::rollBack();
            throw new \Exception("User could not be crated, please try again !!!");
        }
    }

    public function getUser($userId)
    {
        return User::query()->find($userId);
    }

    public function updateUser($data, $user)
    {

        $user = User::query()->find($user->id);
        return $user->update($data);


    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }
}
