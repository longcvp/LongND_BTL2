<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

	use SoftDeletes;

    protected $fillable = [
    	'name', 'user_id', 'type', 'parent_id'
    ];
    
	protected $dates = ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
