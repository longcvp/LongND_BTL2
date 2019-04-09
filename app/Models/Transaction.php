<?php

namespace App\Models;

use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'category_id', 'from_wallet_id', 'to_wallet_id', 'money', 'type', 'user_id'
    ];

    protected $dates = 'deleted_at';

    function public category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }

    function public from_wallet()
    {
    	return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    function public category()
    {
    	return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
}
