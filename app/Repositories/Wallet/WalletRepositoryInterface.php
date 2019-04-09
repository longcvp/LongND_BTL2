<?php
namespace App\Repositories\Wallet;

interface WalletRepositoryInterface
{
	public function getWalletUser($id);

	public function saveWallet($data);

	public function getWalletById($id);

	public function updateInfoWallet($data);
	
	public function deleteWallet($id);
}