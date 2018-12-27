<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Consignor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class ConsignorController extends Controller
{
    public function __construct(Admin $admin, Consignor $consignor/*, Item $item, Tag $tag, Category $category, TagRelation $tagRelation*/)
    {
    
        $this -> middleware(['adminauth', 'role:isAdmin']);
        //$this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this -> consignor = $consignor;
//        $this-> item = $item;
//        $this->category = $category;
//        $this -> tag = $tag;
//        $this->tagRelation = $tagRelation;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    { 
     
        $consignors = Consignor::orderBy('id', 'desc')->paginate($this->perPage);
        
        //$cates= $this->category;
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.consignor.index', ['consignors'=>$consignors, ]);
    }

    public function show($id)
    { 

        $consignor = $this->consignor->find($id);
        //$cates = $this->category->all();
        //$users = $this->user->where('active',1)->get();
        
        
        return view('dashboard.consignor.form', ['consignor'=>$consignor, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
    	
        
//        $cates = $this->category->all();
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.consignor.form', [/*'cates'=>$cates, 'allTags'=>$allTags*/]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
        $rules = [
            'name' => 'required|max:255',
            //'movie_url' => 'required|max:255',
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
             'name.required' => '「出荷元名」を入力して下さい。',
            //'cate_id.required' => '「カテゴリー」を選択して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        //status
//        if(isset($data['open_status'])) { //非公開On
//            $data['open_status'] = 0;
//        }
//        else {
//            $data['open_status'] = 1;
//        }
        
        if($editId) { //update（編集）の時
            $status = '出荷元が更新されました！';
            $consignor = $this->consignor->find($editId);
        }
        else { //新規追加の時
            $status = '出荷元が追加されました！';
            //$data['model_id'] = 1;
            
            $consignor = $this->consignor;
        }
        
        $consignor->fill($data);
        $consignor->save();
        $consignorId = $consignor->id;
        
        return redirect('dashboard/consignors/'. $consignorId)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('dashboard/items/'.$id);
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
        
        $atcls = $this->item->where('cate_id', $id)->get()->map(function($item){
            $item->cate_id = 0;
            $item->save();
        });
        
        $cateDel = $this->category->destroy($id);
        
        $status = $cateDel ? '商品「'.$name.'」が削除されました' : '商品「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/items')->with('status', $status);
    }
}
