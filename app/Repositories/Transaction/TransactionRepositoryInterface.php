<?php
namespace App\Repositories\Transaction;

interface TransactionRepositoryInterface
{
	public function createTransfer($data, $toWalletId = 0);

	public function getTransactionUser($id);

	
}