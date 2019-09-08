<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;
    
    protected $table ='wallets';

    protected $fillable = [
        'name', 'user_id', 'code', 'reset_code', 'money', 'ssid'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWalletByUserId($user_id)
    {
        return $this->where('user_id', $user_id)->paginate(8);
    }

    public function saveWallet($data)
    {
        $ssid = $this->getSSID();
        $newData = [
            'name' => $data->name,
            'user_id' => $data->id,
            'code' => bcrypt($data->code),
            'reset_code' => NO_RESET_PASS,
            'money' => $data->money,
            'ssid' => $ssid,

        ];
        return $this->create($newData);
    }

    public function getSSID()
    {
        return '1000' . rand(1000,9999).rand(1000,9999);
    }

    public function getWalletBySSID($ssid)
    {
        return $this->where('ssid', $ssid)->first();
    }
}
