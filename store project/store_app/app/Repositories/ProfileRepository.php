<?php
namespace App\Repositories;
use App\Models\User;
use App\Services\UserService;

class ProfileRepository implements ProfileRepositoryInterface
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function get_all_profiles():array
    {
        $users = User::query()
            ->select('id' , 'name' , 'email' , 'referral_code', 'referred_by_code')
            ->paginate(50);

        if (!is_null($users)){
            foreach ($users as $user) {
                $user->load('roles', 'permissions');
                $user = $this->userService->appendRolesAndPermissions($user);
            }
            $message = 'getting all users successfully';
        }else{
            $users = null;
            $message = 'there is no users at the moment';
        }
        return [
            'users' => $users,
            'message' => $message,
        ];
    }
    public function show_profile($id): array
    {
        $user = User::query()->
        where('id' , $id)
        ->select('id' , 'name' , 'email' , 'referral_code', 'referred_by_code')
        ->first();
        if (!is_null($user)) {
            $user->load('roles', 'permissions');
            $user = $this->userService->appendRolesAndPermissions($user);
            $message = 'getting user successfully';
        }else{
            $user = null;
            $message = 'the user not found';
        }
        return [
            'user' => $user,
            'message' => $message,
        ];
    }

    public function update_profile($id, array $data)
    {
        return User::query()->where('id', $id)->update($data);
    }
    public function delete_profile($id)
    {
        return User::destroy($id);
    }
}
