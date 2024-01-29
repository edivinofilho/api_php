<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\AppError;
// use Illuminate\Support\Facedes\Log;

class CreateDepositService {
    public function execute(string $userId, float $value){
        $userFound = user::find($userId);

        if(is_null($userFound)){
            throw new AppError('User not found', 404);
        }

        $userFound->balance += $value;
        $userFound->save();

        return $userFound;
    }
}