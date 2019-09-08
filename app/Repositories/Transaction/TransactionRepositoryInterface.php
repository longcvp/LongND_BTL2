<?php
namespace App\Repositories\Transaction;

interface TransactionRepositoryInterface
{
    public function createTransfer($data, $toWalletId = 0);

    public function getTransactionUser($userId);

    public function getTransactionCategory($userId);

    public function getTransferUser($userId);

    public function getAllByDay($data, $userId);

    public function getAllByMonth($data, $userId);

}