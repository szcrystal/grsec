<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\DeliveryCompany;
//use App\DeliveryGroupRelation;
//use App\Prefecture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryCompanyController extends Controller
{
    public function __construct(Admin $admin, DeliveryCompany $dc)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> dc = $dc;
//        $this->dgRel = $dgRel;
//        $this->prefecture = $prefecture;
        
        
        $this->perPage = 20;
        
    }
    
    
    public function index()
    {
        //$dgs = $this->dg->orderBy('id', 'asc')->paginate($this->perPage);
        $dcs = $this->dc->orderBy('id', 'asc')->get();
        
        //$dgRels = $this->dgRel;
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.dc.index', ['dcs'=>$dcs]);
    }

    public function show($id)
    {
        $dc = $this->dc->find($id);
        //$users = $this->user->where('active',1)->get();
        
//        $tagNames = $this->tagRelation->where(['item_id'=>$id])->get()->map(function($item) {
//            return $this->tag->find($item->tag_id)->name;
//        })->all();
//        
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
        
        return view('dashboard.dc.form', ['dc'=>$dc, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
//        $cates = $this->category->all();
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.dc.form', []);
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
            'name_code' => 'required|unique:delivery_companies,name_code,'.$editId.'|max:255', /* |unique:admins 注意:unique */
 
            //'time_table' => 'required_with:is_time|max:255',
            
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
            //'time_table.required_with' => '「時間帯」を入力して下さい。',
            'name.required' => '「配送会社名」を入力して下さい。',
            'name.max' => '「配送会社名」は255文字以内で入力して下さい。',
            'name_code.required' => '「コード名」を入力して下さい。',
            'name_code.max' => '「コード名」は255文字以内で入力して下さい。',
            'name_code.unique' => '「コード名」が既に存在します。',
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
        
        $data['open_status'] = isset($data['open_status']) ? 0 : 1;
        //$data['is_time'] = isset($data['is_time']) ? 1 : 0;
        //$data['take_charge'] = isset($data['take_charge']) ? $data['take_charge'] : 0;
        
        if($editId) { //update（編集）の時
            $status = '配送会社が更新されました！';
            $dc = $this->dc->find($editId);
        }
        else { //新規追加の時
            $status = '配送会社が追加されました！';
            //$data['model_id'] = 1;
            
            $dc = $this->dc;
        }
        
        $dc->fill($data);
        $dc->save();
        $dcId = $dc->id;
        
        
        return redirect('dashboard/dcs/'. $dcId)->with('status', $status);
    }

    
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
        
        $atcls = $this->item->where('cate_id', $id)->get()->map(function($item){
            $item->cate_id = 0;
            $item->save();
        });
        
        $cateDel = $this->category->destroy($id);
        
        $status = $cateDel ? '商品「'.$name.'」が削除されました' : '商品「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/items')->with('status', $status);
    }
}
