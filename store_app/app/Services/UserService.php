<?php
namespace App\Services;

use App\Mail\ResetPasswordMail;
use App\Models\Cart;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class UserService{
    public function register_as_client($request): array
    {
        // Validate if the referred_by_code exists in the request and in the database
        if (!empty($request['referred_by_code'])) {
            $referrer = User::query()
                ->where('referral_code', $request['referred_by_code'])
                ->first();

            if (!$referrer) {
                return[
                'user' => null,
                'message' => 'Invalid referral code.',
                ];
            }

            // Optionally, store the referrer ID or log the referral in a separate table
            $request['referrer_id'] = $referrer->id; // For example, to link the referrer
        }

        // Generate a unique referral code for the new user
        do {
            $referralCode = 'R-' . strtoupper(Str::random(8));
        } while (User::where('referral_code', $referralCode)->exists());

        $request['referral_code'] = $referralCode;

        // Create the user
        $user = User::query()->create($request);

        // Create associated records: cart and wallet
        Cart::query()->create(['user_id' => $user->id]);
        Wallet::query()->create(['user_id' => $user->id]);

        // Assign the "client" role to the user
        $clientRole = Role::query()
            ->where('name', '=', 'client')
            ->first();

        $user->assignRole($clientRole);

        // Assign permissions associated with the client role
        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);

        // Load roles and permissions for response
        $user->load('roles', 'permissions');

        // Reload user instance to get updated roles and permissions
        $user = User::query()->find($user['id']);
        $user = $this->appendRolesAndPermissions($user);
        $user['token'] = $user->createToken("token")->plainTextToken;

        // Trigger email verification
        event(new Registered($user));

        $message = 'User has been registered successfully. A verification link has been sent to your email address. Please check your inbox.';

        return [
            'user' => $user,
            'message' => $message,
        ];
    }


    public function register_as_seller($request):array
    {
        do {
            $referralCode = strtoupper(Str::random(8));
        } while (User::where('referral_code', $referralCode)->exists());

        $request['referral_code'] = $referralCode;

        $user = User::query()->create($request);

        Cart::query()->create([
            'user_id' => $user->id
        ]);

        $clientRole = Role::query()
            ->where('name' , '=' , 'seller')
            ->first();

        $user->assignRole($clientRole);

        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $user->givePermissionTo($permissions);
        //show roles and permissions on response
        $user->load('roles' , 'permissions');

        //reload user instance to get updated roles and permissions
        $user = User::query()->find($user['id']);
        $user = $this->appendRolesAndPermissions($user);
        $user['token'] = $user->createToken("token")->plainTextToken;

        event(new Registered($user));
        $message = 'user has been registered successfully. A verification link has been sent to your email address. Please check your inbox.';
        return [
            'user' => $user,
            'message' => $message,
        ];
    }

    public function login($request):array
    {
        $user = User::query()
            ->where('email' , $request['email'])
            ->first();
        if (!is_null($user)){
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = $this->appendRolesAndPermissions($user);
            $user['token'] = $user->createToken("token")->plainTextToken;
            $message = 'logged in successfully';
        }else{
            $user = [];
            $message = 'email and password do not match';
        }
        }else{
            $user = [];
            $message = 'user not found please sign up first';
        }
        return [
            'user' => $user,
            'message' => $message,
        ];
    }

    public function logout():array
    {
        $user = Auth::user();
        if (!is_null($user)){
            auth()->user()->tokens()->delete();
            $message = 'logged out successfully';
        }else{
            $user = [];
            $message = 'invalid token';
        }
        return [
            'user' => $user,
            'message' => $message,
        ];
    }

    //function to add roles and permissions to user array
    public function appendRolesAndPermissions($user)
    {
        $roles=[];
        foreach ($user->roles as $role){
            $roles []= $role->name;
        }
        unset($user['roles']);
        $user['roles']=$roles;

        $permissions=[];
        foreach ($user->permissions as $permission) {
            $permissions [] =$permission->name;
        }

        unset($user['permissions']);
        $user['permissions']=$permissions;

        return $user;
    }


    public function forget_password($request):array
    {
        $email = $request['email'];

        //store email in session
        $request->session()->regenerate();
        Session::put('reset_email',$email);
        ResetCodePassword::query()
            ->where('email' , $email)
            ->delete();

        $code = random_int(100000,999999);

        ResetCodePassword::query()
            ->create([
                'code' =>  $code,
                'email' => $email,
            ]);
        $message = "Reset code has been sent successfully to your email";
        $subject = 'Reset Password';
        Mail::to($email)->send(new ResetPasswordMail($subject,$code));
        return [
            'user' => $email,
            'message' => $message,
        ];
    }



    public function resend_code($request):array
    {
        $email = Session::get('reset_email');
        $subject = 'Reset Password';
        $code = random_int(100000,999999);
        Mail::to($email)->send(new ResetPasswordMail($subject , $code));
        ResetCodePassword::query()
            ->where('email' , $email)
            ->update([
                'code' => $code,
            ]);
        $message = 'Reset code has been resend successfully to your email';
                return [
                    'user' => $email,
                    'message' => $message,
                ];
    }

    public function check_code($request):array
    {
        $email = Session::get('reset_email');
        $resetCode = $request['code'];
        ResetCodePassword::query()
            ->where('code' , $resetCode)
            ->where('email' , $email)
            ->first();
        if ($resetCode){
            if ($resetCode['created_at'] < now()->addHour()){
                $resetCode->delete();
                    $code = null;
                    $message = 'the code has expired';
            } else{
                $code = $resetCode;
                $message = 'the code is correct';
            }
        }else{
            $code = null;
            $message = 'Invalid code or email';
        }
        return [
            'code' => $code,
            'message' => $message,
        ];
    }

    public function reset_password($request):array
    {
        $email = Session::get('reset_email');
        $user = User::query()
            ->where('email' , $email)
            ->first();
        if (Hash::check($user->password , $request['password'])){
            $data = null;
            $message = 'The new password cannot be the same as the old password';
        }else{
            User::query()
                ->update([
                    'password' => Hash::make($request['password'])
                ]);
            ResetCodePassword::query()
                ->where('email' , $email)
                ->delete();
            $data = $user;
            $message = 'New password has been set successfully. You can now log in';
        }
        return [
            'data' => $data,
            'message' => $message
        ];
    }


    public function google_handle_call_back():array
    {
        // Retrieve user from Google
        $googleUser = Socialite::driver('google')->user();

        // Check if the user already exists in the database
        $findUser = User::where('email', $googleUser->email)->first();

        if ($findUser) {
            // Update only if needed (Google ID or social type has changed)
            if ($findUser->social_id !== $googleUser->id || $findUser->social_type !== 'google') {
                $findUser->update([
                    'social_id' => $googleUser->id,
                    'social_type' => 'google',
                ]);
            }
            $clientRole = Role::query()
                ->where('name' , '=' , 'client')
                ->first();

            $findUser->assignRole($clientRole);

            $permissions = $clientRole->permissions()->pluck('name')->toArray();
            $findUser->givePermissionTo($permissions);
            //show roles and permissions on response
            $findUser->load('roles' , 'permissions');

            //reload user instance to get updated roles and permissions
            $findUser = User::query()->find($findUser['id']);
            $findUser = $this->appendRolesAndPermissions($findUser);
            $findUser['token'] = $findUser->createToken("token")->plainTextToken;

            Auth::login($findUser);
            return [
                'data' => $findUser,
                'message' => 'logged in successfully',
            ];
        } else {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'social_id' => $googleUser->id,
                'social_type' => 'google',
                'password' => Hash::make(Str::random(8)),
            ]);

            $clientRole = Role::query()
                ->where('name' , '=' , 'client')
                ->first();

            $user->assignRole($clientRole);

            $permissions = $clientRole->permissions()->pluck('name')->toArray();
            $user->givePermissionTo($permissions);
            //show roles and permissions on response
            $user->load('roles' , 'permissions');

            //reload user instance to get updated roles and permissions
            $user = User::query()->find($user['id']);
            $user = $this->appendRolesAndPermissions($user);
            $user['token'] = $user->createToken("token")->plainTextToken;

            Auth::login($user);

            return [
                'data' => $user,
                'message' => 'logged in successfully',
            ];
        }
    }


    public function apple_handle_call_back():array
    {
        // Retrieve user from Google
        $appleUser = Socialite::driver('apple')->user();

        // Check if the user already exists in the database
        $findUser = User::where('social_id', $appleUser->id)->first();

        if ($findUser) {
            // Log in the existing user
            Auth::login($findUser);
            return [
                'data' => $findUser,
                'message' => 'logged in successfully',
            ];
        } else {
            // Create a new user in the database
            $user = User::create([
                'name' => $appleUser->name,
                'email' => $appleUser->email,
                'social_id' => $appleUser->id, // Google ID
                'social_type' => 'apple',
                'password' => Hash::make(Str::random(8)),
            ]);

            $clientRole = Role::query()
                ->where('name' , '=' , 'client')
                ->first();

            $user->assignRole($clientRole);

            $permissions = $clientRole->permissions()->pluck('name')->toArray();
            $user->givePermissionTo($permissions);
            //show roles and permissions on response
            $user->load('roles' , 'permissions');

            //reload user instance to get updated roles and permissions
            $user = User::query()->find($user['id']);
            $user = $this->appendRolesAndPermissions($user);
            $user['token'] = $user->createToken("token")->plainTextToken;


            Auth::login($user);
            return [
                'data' => $user,
                'message' => 'logged in successfully',
            ];
        }

    }
}
