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

    public function createTransfer($data)
    {
        $newData = [
            'category_id' => 0,
            'from_wallet_id' => $data->from_wallet,
            'to_wallet_id' => $data->to_wallet,
            'type' => TRANSFER,
            'money' => $data->money,
            'user_id' => $data->id
        ];

        return $this->create($newData);
    }
}
