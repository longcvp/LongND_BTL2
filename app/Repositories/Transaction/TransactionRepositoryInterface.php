<?php
namespace App\Repositories\Transaction;

interface TransactionRepositoryInterface
{
	public function createTransfer($data);
}