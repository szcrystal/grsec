<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Tag;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct(Admin $admin, Tag $tag)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->tag = $tag;
        
        $this->perPage = 30;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')
           //->take(10)->get();
           ->paginate($this->perPage);
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.tag.index', ['tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.tag.form');
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
            //'name' => 'required|same_tag:'.$editId.','.$groupId.'|max:255', //same_tag-> on AppServiceProvider
            'name' => 'required|unique:tags,name,'.$editId.'|max:255',
            'slug' => 'required|unique:tags,slug,'.$editId.'|max:255', /* |unique:admins 注意:unique */
        ];
        
        $messages = [
            'name.unique' => '「タグ名」が既に存在します。',
            'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
            $tagModel = $this->tag->find($request->input('edit_id'));
            $upText = 'タグが更新されました';
        }
        else { //新規追加の時
            $tagModel = $this->tag;
            $upText = 'タグが追加されました';
            //$data['view_count'] = 0;
        }
        
        $tagModel->fill($data); //モデルにセット
        $tagModel->save(); //モデルからsave
        
        $id = $tagModel->id;

        return redirect('dashboard/tags/'. $id)->with('status', $upText);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tagId)
    {
        $tag = $this->tag->find($tagId);
        
        return view('dashboard.tag.form', ['tag'=>$tag, 'tagId'=>$tagId, 'edit'=>1]);
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
        $name = $this->tag->find($id)->name;
        
        //tag relationをここで消す
//        $atcls = $this->article->where('cate_id', $id)->get()->map(function($atcl){
//            $atcl->cate_id = 0;
//            $atcl->save();
//        });
        
        $tagDel = $this->tag->destroy($id);
        
        $status = $tagDel ? 'タグ「'.$name.'」が削除されました' : 'タグ「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/tags')->with('status', $status);
    }
}
