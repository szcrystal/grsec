<?php

namespace App\Http\Controllers\DashBoard;

use App\Category;
use App\CategorySecond;
use App\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategorySecondController extends Controller
{
    public function __construct(Category $category, CategorySecond $cateSec, Item $item)
    {
        $this->category = $category;
        $this->cateSec = $cateSec;
        $this->item = $item;
        $this->perPage = 30;
    }
    
    public function index()
    {
    	$cates = $this->category->all();
        
        $subCates = CategorySecond::orderBy('id', 'desc')
           //->take(10)
           ->paginate($this->perPage);
        
        return view('dashboard.categorySecond.index', ['subCates'=>$subCates, 'cates'=>$cates]);
    }

    public function show($id)
    {
    	$cates = $this->category->all();
        $subCate = $this->cateSec->find($id);
        
        return view('dashboard.categorySecond.form', ['subCate'=>$subCate, 'cates'=>$cates, 'id'=>$id, 'edit'=>1]);
    }
    
    
    public function create()
    {
    	$cates = $this->category->all();
        
        return view('dashboard.categorySecond.form', ['cates'=>$cates]);
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
        	'parent_id' => 'required',
            'name' => 'required|unique:categories,name,'.$editId.'|max:255',
            'slug' => 'required|unique:categories,slug,'.$editId.'|max:255', /* 注意:unique */
        ];
        
        $messages = [
        	'parent_id'=>'「親カテゴリー」は必須です。',
            'name.required' => '「子カテゴリー名」は必須です。',
            'name.unique' => '「子カテゴリー名」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all(); //requestから配列として$dataにする
        
//        if(! isset($data['open_status'])) { //checkbox
//            $data['open_status'] = 0;
//        }
        

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
            $status = '子カテゴリーが更新されました！';
            $cateModel = $this->cateSec->find($request->input('edit_id'));
        }
        else { //新規追加の時
            $status = '子カテゴリーが追加されました！';
            $data['view_count'] = 0;
            $cateModel = $this->cateSec;
        }
        
        $cateModel->fill($data); //モデルにセット
        $cateModel->save(); //モデルからsave
        
        $id = $cateModel->id;

        return redirect('dashboard/categories/sub/'.$id)->with('status', $status);
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
