<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\AppError;
// use Illuminate\Support\Facedes\Log;

class CreateUserService {
    public function execute(array $data){
        // Log::info('Usuario service');
        // Log::debug('Esse é um debug');

        $userFound = User::firstWhere('email', $data['email']);

        if(!is_null($userFound)) {
            throw new AppError('Email já cadastrado', 400);
        }

        $userFound = User::firstWhere('cpf', $data['cpf']);

        if(!is_null($userFound)) {
            throw new AppError('CPF já cadastrado', 400);
        }

        return User::create($data);
    }
}