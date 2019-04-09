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
}