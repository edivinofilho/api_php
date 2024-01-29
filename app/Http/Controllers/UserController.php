<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CreateUserRequest, CreateDepositRequest};
use App\Models\User;
use App\Services\{CreateUserService, CreateDepositService};

// create Model in Laravel
class UserController extends Controller {
    public function create(CreateUserRequest $request) {
        // return User::create($request->all()); 
        $createUserService = new CreateUserService();

        return $createUserService->execute($request->all());
    }

    public function deposit(CreateDepositRequest $request) {
        $createDepositService = new CreateDepositService();

        return $createDepositService->execute(
            auth()->user()->id,
            $request->value
        );
    }
};