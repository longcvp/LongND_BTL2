<?php
namespace App\Repositories\Active;

use App\Models\ActiveUser;
use Illuminate\Support\Facades\DB;
use App\Repositories\EloquentRepository;

class ActiveEloquentRepository extends EloquentRepository implements ActiveRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ActiveUser::class;
    }

    public function getUserByToken($token)
    {
    	return $this->_model->findByToken($token);
    }

    public function deleteToken($token)
    {
        return $this->_model->deleteByToken($token);
    }

}