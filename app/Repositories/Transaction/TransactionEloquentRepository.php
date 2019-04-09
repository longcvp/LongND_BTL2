<?php
namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\EloquentRepository;



class TransactionEloquentRepository extends EloquentRepository implements TransactionRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Transaction::class;
    }

}