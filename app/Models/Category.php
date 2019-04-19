<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name', 'user_id', 'type', 'parent_id'
    ];
    
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCateByUser($id)
    {
        return $this->where('user_id', $id)->paginate(8);
    }

    public function getRootCategoryUser($data)
    {
        return $this->where('user_id', $data->user_id)->where('type', $data->type)->where('parent_id', ROOT_CATEGORY)->get();
    }

    public function createCategory($data)
    {
        $newData = [
            'name' => $data->name,
            'user_id' => $data->user_id,
            'type' => $data->type,
            'parent_id' => $data->parent_id
        ];
        return $this->create($newData);
    }

    public function nameParent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function getChildCategory($id)
    {
        return $this->where('parent_id', $id)->get();        
    }

    public function deleteChildCategory($id)
    {
        return $this->where('parent_id', $id)->delete();
    }

    public function getChildCategoryUser($data)
    {
        return $this->where('user_id', $data->user_id)->where('type', $data->type)->where('parent_id', '<>', ROOT_CATEGORY)->get();      
    }    

    public function getRootCatgory($userId)
    {
        return $this->where('user_id', $userId)->where('parent_id', ROOT_CATEGORY)->get(); 
    }

    public function getChildId($userId, $id)
    {
        return $this->where('user_id', $userId)->where('parent_id', $id)->get();
    }
}
