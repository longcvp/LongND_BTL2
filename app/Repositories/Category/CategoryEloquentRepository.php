<?php
namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\EloquentRepository;



class CategoryEloquentRepository extends EloquentRepository implements CategoryRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Category::class;
    }


    public function getDataCategorys()
    {   
        return $this->_model->with('information', 'users')->paginate(8);
    }

    public function saveCategory($data)
    {
        $Category_info = [
            'name' => $data->name,
            'manager_id' => $data->manager_id,  
        ];
        DB::transaction(function() use ($Category_info) {
            $new_Category = $this->_model->create($Category_info);
            $this->updateUserLevel($new_Category);
        });
        
    }

    public function updateUserLevel($Category,$old_Category = null)
    {
        if (!is_null($old_Category)) {            
            User::where('id', $old_Category->manager_id)->update(['Category_level' => 1]);
        }
        $update_new_manager = [
            'Category_level' => 2, 
            'Category_id' => $Category->id,
        ];
        User::where('id', $Category->manager_id)->update($update_new_manager);
    }

    public function getCategoryById($id)
    {
        return $this->_model->find($id);
    }

    public function updateCategory($data, $id)
    {
        $old_Category = $this->getCategoryById($id);
        $Category_info = [
            'name' => $data->name,
            'manager_id' => $data->manager_id,  
        ];
        DB::transaction(function() use ($Category_info, $id, $old_Category) {
            $this->_model->where('id', $id)->update($Category_info);
            $update_Category = $this->getCategoryById($id);
            $this->updateUserLevel($update_Category,$old_Category);
        });

    }

    public function deleteCategory($id)
    {
        $delete_Category = $this->_model->find($id);

        DB::transaction(function() use ($delete_Category) {
            foreach ($delete_Category->users as $user) {
                $user->update(['Category_id' => 0, 'Category_level' => 1]);
            }
            $delete_Category->delete();
        });        
    }
}