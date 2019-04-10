<?php
namespace App\Repositories\Wallet;

use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\EloquentRepository;

class WalletEloquentRepository extends EloquentRepository implements WalletRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Wallet::class;
    }

	public function getWalletUser($id)
	{
		return $this->_model->getWalletByUserId($id);
	}

	public function saveWallet($data)
	{
		return $this->_model->saveWallet($data);
	}

	public function getWalletById($id)
	{
		return $this->_model->find($id);
	}

	public function updateInfoWallet($data)
	{
		return $this->_model->find($data->id)->update(['name' => $data->name]);
	}

	public function deleteWallet($id)
	{
		return $this->getWalletById($id)->delete();
	}

	public function changeTransferWallet($data)
	{	
		$wallets = $this->getWalletUser($data->id);
		$output = '<option value="">Chọn ví chuyển đến</option>';
		foreach($wallets as $wallet) {
			if ($wallet->id != $data->from_wallet) {
				$output .= '<option value="'.$wallet->id.'">'.$wallet->name.'-'.$wallet->ssid.'</option>';
			}
		}
		$fromWallet =  $this->getWalletById($data->from_wallet);
		$dataReturn = [$output, $fromWallet->money];

		return $dataReturn;
	}

	public function updateMoneyTransfer($data)
	{
		$toWalletId = 0;
        if ($data->trans == OUT) {
            $wallet = $this->_model->getWalletBySSID($data->ssid);
            $toWalletId = $wallet->id;
        } else {
            $toWalletId = $data->to_wallet;
        }
		$walletFrom = $this->_model->find($data->from_wallet);
		$walletTo = $this->_model->find($toWalletId);
		$walletFrom->update(['money' => $walletFrom->money - $data->money]);
		$walletTo->update(['money' => ($walletTo->money + $data->money)]);
		return $toWalletId;		
	}

	public function updateMoneyTransaction($data)
	{
		if ($data->type == THU) {
			$walletFrom = $this->_model->find($data->from_wallet);
			$walletFrom->update(['money' => $walletFrom->money + $data->money]);
		} else {
			$walletFrom = $this->_model->find($data->from_wallet);
			$walletFrom->update(['money' => $walletFrom->money - $data->money]);
		}
		
	}
}