<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Tag;
use App\ItemImage;
use App\Setting;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;

class TagController extends Controller
{
    public function __construct(Admin $admin, Tag $tag, ItemImage $itemImg, Setting $setting)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->tag = $tag;
        
        $this->itemImg = $itemImg;
        $this->setting = $setting;
        
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

    public function show($tagId)
    {
        $tag = $this->tag->find($tagId);
        
        $snaps = $this->itemImg->where(['item_id'=>$tagId, 'type'=>4])->get();
        
        $imgCount = $this->setting->get()->first()->snap_category;
        
        return view('dashboard.tag.form', ['tag'=>$tag, 'tagId'=>$tagId, 'snaps'=>$snaps, 'imgCount'=>$imgCount, 'edit'=>1]);
    }
    
    public function create()
    {
    	$imgCount = $this->setting->get()->first()->snap_category;
        
        return view('dashboard.tag.form', ['imgCount'=>$imgCount, ]);
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
        
        $tagId = $tagModel->id;
        
        //Snap Save ==================================================
        foreach($data['snap_count'] as $count) {
        
            /*
                type:1->item main
                type:2->item spare
                type:3->category
                type:4->sub category
                type:5->tag                              
            */         
 
            if(isset($data['del_snap'][$count]) && $data['del_snap'][$count]) { //削除チェックの時
                
                $snapModel = $this->itemImg->where(['item_id'=>$tagId, 'type'=>5, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                    Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $snapModel ->delete();
                }
            
            }
            else {
                if(isset($data['snap_thumb'][$count])) {
                    
                    $snapImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$tagId, 'type'=>5, 'number'=>$count+1],
                        [
                            'item_id'=>$tagId,
                            //'snap_path' =>'',
                            'type' => 5,
                            'number'=> $count+1,
                        ]
                    );

                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'tag/' . $tagId . '/snap/'/* . $pre*/ . $filename;
                    //if (App::environment('local'))
                    $path = $data['snap_thumb'][$count]->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    //$data['model_thumb'] = $filename;
                    
                    $snapImg->img_path = $filename;
                    $snapImg->save();
                }
            }
            
        } //foreach
        
        $num = 1;
        $snaps = $this->itemImg->where(['item_id'=>$tagId, 'type'=>5])->get();
//            $snaps = $this->modelSnap->where(['model_id'=>$modelId])->get()->map(function($obj) use($num){
//                
//                return true;
//            });
        
        //Snapのナンバーを振り直す
        foreach($snaps as $snap) {
            $snap->number = $num;
            $snap->save();
            $num++;
        }
        
        //Snap END ===========================================

        return redirect('dashboard/tags/'. $tagId)->with('status', $upText);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

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
