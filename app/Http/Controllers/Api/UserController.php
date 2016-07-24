<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\SignupUserRequest;
use App\Models\User\User;
use App\Models\User\UserRepositoryInterface;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param SignupUserRequest $request
     * @param UserRepositoryInterface $userRepository
     * @return Response
     */
    public function signup(SignupUserRequest $request, UserRepositoryInterface $userRepository)
    {
        $user = $userRepository->create($request->all());
        return $this->response($user, Response::HTTP_CREATED);
    }

    /**
     * @param LoginUserRequest $request
     * @param UserRepositoryInterface $userRepository
     * @return Response
     */
    public function login(LoginUserRequest $request, UserRepositoryInterface $userRepository)
    {
        $user = $userRepository->findByCredentials($request->email, $request->password);

        if (!$user instanceof User) {
            return $this->status(Response::HTTP_UNAUTHORIZED);
        }

        return $this->response($user);
    }
}
