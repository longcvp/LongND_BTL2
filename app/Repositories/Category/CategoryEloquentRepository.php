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


    public function getCategoryUser($id)
    {   
        return $this->_model->getCateByUser($id);
    }

    public function getRootCategoryUser($data)
    {   
        return $this->_model->getRootCategoryUser($data);
    }

    public function changeCateType($data)
    {
        $output = '';
        if (is_null($data->child)) {
             $output .= '<option value="0">Danh mục cấp 1</option>';
            $categories = $this->_model->getRootCategoryUser($data);
        } else {
            $output .= '<option value="">Chọn danh mục để giao dịch</option>';
            $categories = $this->_model->getChildCategoryUser($data);
        }
       
        foreach($categories as $category) {
            $output .= '<option value="' . $category->id . '">' . $category->name . '</option>';
        }
        return $output;
    }

    public function saveCategory($data)
    {
        return $this->_model->createCategory($data);
    }

    public function updateCategory($data)
    {
        $updateData = $data->all();
        return $this->_model->find($data->id)->update($updateData);
    }

    public function deleteCategory($id)
    {
        $category = $this->_model->find($id);
        if ($category->parent_id == 0) {
            $this->_model->deleteChildCategory($id);
            $category->delete();
        } else {
            $category->delete();
        }
        
    }

    public function getRootCatgory($userId)
    {
        return $this->_model->getRootCatgory($userId);
    }

    public function getChildId($userId, $id)
    {
        $data = array();
        $childs = $this->_model->getChildId($userId, $id);
        foreach ($childs as $value) {
            $data[] = $value->id;
        }
        return $data;
    }
}