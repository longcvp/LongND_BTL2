<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;

class CategoryController extends Controller
{
    /**
        repository 
    */
    protected $user;
    protected $transaction;
    protected $category;

    public function __construct(UserRepositoryInterface $user, CategoryRepositoryInterface $category,TransactionRepositoryInterface $transaction)
    {
        $this->user = $user;
        $this->category = $category;
        $this->transaction = $transaction;
    }  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->getCategoryUser(Auth::id());
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $req)
    {
        $this->category->saveCategory($req);
        return redirect()->route('categories.index')->with('success', 'Tạo danh mục thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        $parentRoot = $this->category->getRootCategoryUser($category);
        if ($category->user_id != Auth::id()) {
           return redirect()->back();
        } else {
           return view('categories.edit', ['category' => $category, 'parentRoot' => $parentRoot]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $this->category->updateCategory($request);
        return redirect()->route('categories.index')->with('success', 'Sửa danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        if ($category->user_id != Auth::id()) {
           return redirect()->back();
        } else {
            $this->category->deleteCategory($id);
            return redirect()->route('categories.index')->with('success', 'Xóa thành công');
        }
    }

    public function changeType(Request $req)
    {
        // dd($req->all());
        echo $this->category->changeCateType($req);
    }
}
