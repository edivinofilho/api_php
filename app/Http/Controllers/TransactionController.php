<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Services\CreateTransactionService;

// create Model in Laravel
class TransactionController extends Controller {
    public function create(CreateTransactionRequest $request) {
        $createTransactionService = new CreateTransactionService();

        return $createTransactionService->execute($request->all());
    }
};