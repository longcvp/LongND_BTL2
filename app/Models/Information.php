<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
	use SoftDeletes;

	protected $table = 'infomations';
	
    protected $fillable = [
        'name', 'phone', 'user_id', 'avatar', 'address', 'gender', 'birthday'
    ]; 

	protected $dates = ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
