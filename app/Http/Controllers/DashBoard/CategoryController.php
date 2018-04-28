<?php

namespace App\Http\Controllers\DashBoard;

use App\Category;
use App\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct(Category $category, Item $item)
    {
        $this->category = $category;
        $this->item = $item;
        $this->perPage = 30;
    }
    
    public function index()
    {
        $cates = Category::orderBy('id', 'desc')
           //->take(10)
           ->paginate($this->perPage);
        
        return view('dashboard.category.index', ['cates'=>$cates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $editId = $request->input('edit_id');
        
        $rules = [
            'name' => 'required|unique:categories,name,'.$editId.'|max:255',
            'slug' => 'required|unique:categories,slug,'.$editId.'|max:255', /* 注意:unique */
        ];
        
        $messages = [
            'name.required' => '「カテゴリー名」は必須です。',
            'name.unique' => '「カテゴリー名」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all(); //requestから配列として$dataにする
        
//        if(! isset($data['open_status'])) { //checkbox
//            $data['open_status'] = 0;
//        }
        

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
            $status = 'カテゴリーが更新されました！';
            $cateModel = $this->category->find($request->input('edit_id'));
        }
        else { //新規追加の時
            $status = 'カテゴリーが追加されました！';
            $data['view_count'] = 0;
            $cateModel = $this->category;
        }
        
        $cateModel->fill($data); //モデルにセット
        $cateModel->save(); //モデルからsave
        
        $id = $cateModel->id;

        return redirect('dashboard/categories/'.$id)->with('status', $status);
    }


    public function show($id)
    {
        $cate = $this->category->find($id);
        
        return view('dashboard.category.form', ['cate'=>$cate, 'id'=>$id, 'edit'=>1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $name = $this->category->find($id)->name;
        
        $atcls = $this->article->where('cate_id', $id)->get()->map(function($atcl){
            $atcl->cate_id = 0;
            $atcl->save();
        });
        
        $cateDel = $this->category->destroy($id);
        
        $status = $cateDel ? 'カテゴリー「'.$name.'」が削除されました' : '記事「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/categories')->with('status', $status);
    }
    
}
