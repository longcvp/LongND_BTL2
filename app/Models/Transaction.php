<?php

namespace App\Models;

use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
    	'category_id', 'from_wallet_id', 'to_wallet_id', 'money', 'type', 'user_id'
    ];

    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }

    public function fromWallet()
    {
    	return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function  toWallet()
    {
    	return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }

    public function createTransfer($data, $toWalletId = 0)
    {   
        $category_id = is_null($data->parent_id) ? 0 : $data->parent_id;
        if ($data->type == THU) {
            $toWallet = $data->from_wallet;
            $fromWallet = 0;
        } elseif ($data->type == CHI) {
            $fromWallet = $data->from_wallet;
            $toWallet = 0;
        } else {
            $toWallet = ( $toWalletId == 0 ) ? $data->to_wallet : $toWalletId;
            $fromWallet = $data->from_wallet;            
        }
        
        $newData = [
            'category_id' => 0,
            'from_wallet_id' => $fromWallet,
            'category_id' => $category_id,
            'to_wallet_id' => $toWallet,
            'type' => $data->type,
            'money' => $data->money,
            'user_id' => $data->id
        ];

        return $this->create($newData);
    }

    public function getDataTransaction($id)
    {
        return $this->where('user_id', $id)->paginate(8);
    }

    public function getTransactionCategory($id)
    {
        return $this->where('user_id', $id)
                    ->where('category_id', '<>', 0)
                    ->paginate(8);
    }

    public function getTransfer($id)
    {
        return $this->where('user_id', $id)
                    ->where('category_id', 0)
                    ->paginate(8);
    }

    public function getDataByDay($startDate, $afterDate, $userId)
    {
        return $this->where('user_id', $userId)
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<', $afterDate)
                    ->get();
    }

    public function getDataByMonth($month, $year, $userId)
    {
        return $this->whereMonth('created_at',$month)
                    ->whereYear('created_at',$year)
                    ->where('user_id',$userId)
                    ->get();
    }
}
