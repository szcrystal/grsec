<?php

namespace App\Http\Controllers\DashBoard;

use App\Category;
use App\Item;
use App\ItemImage;
use App\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;

use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct(Category $category, Item $item, ItemImage $itemImg, Setting $setting)
    {
        $this->category = $category;
        $this->item = $item;
        $this->itemImg = $itemImg;
        $this->setting = $setting;
        
        $this->perPage = 30;
    }
    
    public function index()
    {
        //$cates = Category::orderBy('id', 'desc')->paginate($this->perPage);
        $cates = Category::orderBy('id', 'desc')->get();
        
        return view('dashboard.category.index', ['cates'=>$cates]);
    }

    public function show($id)
    {
        $cate = $this->category->find($id);
        
        $snaps = $this->itemImg->where(['item_id'=>$id, 'type'=>3])->get();
        
        $imgCount = $this->setting->get()->first()->snap_category;
        
        return view('dashboard.category.form', ['cate'=>$cate, 'imgCount'=>$imgCount, 'snaps'=>$snaps, 'id'=>$id, 'edit'=>1]);
    }
    
    
    public function create()
    {
    	$imgCount = $this->setting->get()->first()->snap_category;
        
        return view('dashboard.category.form', ['imgCount'=>$imgCount, ]);
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
            'name' => 'required|unique:categories,name,'.$editId.'|max:255',
            'slug' => 'required|unique:categories,slug,'.$editId.'|max:255', /* 注意:unique */
        ];
        
        $messages = [
            'name.required' => '「カテゴリー名」は必須です。',
            'name.unique' => '「カテゴリー名」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        $data['is_top'] = isset($data['is_top']) ? 1 : 0;

        if($editId) { //update（編集）の時
            $status = 'カテゴリーが更新されました！';
            $cateModel = $this->category->find($editId);
        }
        else { //新規追加の時
            $status = 'カテゴリーが追加されました！';
            $data['view_count'] = 0;
            $cateModel = $this->category;
        }
        
        $cateModel->fill($data); //モデルにセット
        $cateModel->save(); //モデルからsave
        
        $cateId = $cateModel->id;
        
        //for top-img =========================================
        if(isset($data['top_img_path'])) {
                
            //$filename = $request->file('main_img')->getClientOriginalName();
            $filename = $data['top_img_path']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            //$aId = $editId ? $editId : $rand;
            //$pre = time() . '-';
            $filename = 'category/' . $cateId . '/recom/'/* . $pre*/ . $filename;
            //if (App::environment('local'))
            $path = $data['top_img_path']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
            
            $cateModel->top_img_path = $path;
            $cateModel->save();
        }

        
        //Snap Save ==================================================
        foreach($data['snap_count'] as $count) {
        
            /*
               	type:1->item spare
            	type:2->item snap(contents)
                type:3->category
                type:4->sub category
                type:5->tag                              
            */         
 
            if(isset($data['del_snap'][$count]) && $data['del_snap'][$count]) { //削除チェックの時
                //echo $count . '/' .$data['del_snap'][$count];
                //exit;
                
                $snapModel = $this->itemImg->where(['item_id'=>$cateId, 'type'=>3, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                	Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる（storage/app直下）
                    $snapModel ->delete();
                }
            
            }
            else {
                if(isset($data['snap_thumb'][$count])) {
                    
                    $snapImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$cateId, 'type'=>3, 'number'=>$count+1],
                        [
                            'item_id'=>$cateId,
                            //'snap_path' =>'',
                            'type' => 3,
                            'number'=> $count+1,
                        ]
                    );

                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'category/' . $cateId . '/snap/'/* . $pre*/ . $filename;
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
        $snaps = $this->itemImg->where(['item_id'=>$cateId, 'type'=>3])->get();
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

        return redirect('dashboard/categories/'.$cateId)->with('status', $status);
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
        $name = $this->cateSec->find($id)->name;
        
        $atcls = $this->item->where('subcate_id', $id)->get()->map(function($obj){
            $obj->subcate_id = null;
            $obj->save();
        });
        
        $cateDel = $this->cateSec->destroy($id);
        
        //if(Storage::exists('public/subcate/'. $id)) {
        	Storage::deleteDirectory('public/subcate/'. $id); //存在しなければスルーされるようだ
        //}
        
        
        $status = 'カテゴリー「' . $name . '」';
        $status .= $cateDel ? 'が削除されました' : 'が削除出来ませんでした。';
        
        return redirect('dashboard/categories/sub')->with('status', $status);
    }
    
}
