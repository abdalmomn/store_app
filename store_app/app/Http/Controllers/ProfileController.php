<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Responses\Response;
use App\Repositories\profile\ProfileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProfileController extends Controller
{
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
    public function show_all_profiles(): JsonResponse
    {
        $data = [];
        try {
            $data = $this->profileRepository->show_all_profiles();
            return Response::Success($data['users'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }
    public function show_user_profile($id):JsonResponse
    {
        $data = [];
        try {
            $data = $this->profileRepository->show_profile($id);
            return Response::Success($data['user'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update_profile(UpdateProfileRequest $request):JsonResponse
    {
        $user = Auth::user();
        $data = [];
        try {
            $data =  $request->validated();
            $imagePath = $request->file('profile_photo_path')->store('images/profile', 'public');
            $imageUrl = Storage::disk('public')->path($imagePath);
            $data['profile_photo_path'] = $imageUrl;
            $data = $this->profileRepository->update_profile($user,$data);
            return Response::Success($data['user'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data, $message);
        }
    }

    public function update_password(UpdatePasswordRequest $request): JsonResponse
    {
        $data = [];
        try {
            $user = Auth::user();
            $data = $this->profileRepository->update_password($user, $request->new_password);
            return Response::Success($data['user'],$data['message']);
        }catch (Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function delete_my_profile(): JsonResponse
    {
        $data = [];
        try {
            $user = Auth::user();
            $data = $this->profileRepository->delete_my_profile($user);
            return Response::Success($data['user'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }

    public function delete_profile($id): JsonResponse
    {
        $data = [];
        try {
            $data = $this->profileRepository->delete_profile($id);
            return Response::Success($data['user'],$data['message']);
        }catch(Exception $e){
            $message = $e->getMessage();
            return Response::Error($data,$message);
        }
    }
}
