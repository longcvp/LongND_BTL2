<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    protected $table = 'user_activations';

    protected $fillable = ['user_id', 'active_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function findByToken($token)
    {
        $data = $this->where('active_code', $token)->firstOrFail();
        return $data;
    }

    public function deleteByToken($token)
    {
        return $this->where('active_code', $token)->delete();
    }
}