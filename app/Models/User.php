<?php

namespace App\Models;

use App\Models\Wallet;
use App\Models\Category;
use App\Models\Information;
use App\Models\ActiveUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'verified_at', 'active', 'reset_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function infomation()
    {
        return $this->hasOne(Information::class);
    }

    public function active()
    {
        return $this->hasOne(ActiveUser::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function saveUser($data)
    {
        $newData = [
            'username' => $data->username,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'active' => NON_ACTIVE,
            'reset_password' => NO_RESET_PASS
        ];
        return $this->create($newData);
    }

    public function findById($id)
    {
        return $this->with('wallets', 'categories', 'active', 'infomation')
                    ->find($id);
    }

    public function findUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

}
