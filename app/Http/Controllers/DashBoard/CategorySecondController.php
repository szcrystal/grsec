<?php

namespace App\Http\Controllers\DashBoard;

use App\Category;
use App\CategorySecond;
use App\Item;
use App\ItemImage;
use App\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;

class CategorySecondController extends Controller
{
    public function __construct(Category $category, CategorySecond $cateSec, Item $item, ItemImage $itemImg, Setting $setting)
    {
        $this->category = $category;
        $this->cateSec = $cateSec;
        $this->item = $item;
        $this->itemImg = $itemImg;
        $this->setting = $setting;
        
        $this->perPage = 30;
    }
    
    public function index()
    {
    	$cates = $this->category->all();
        
        //$subCates = CategorySecond::orderBy('id', 'desc')->paginate($this->perPage);
        $subCates = CategorySecond::orderBy('id', 'desc')->get();
        
        return view('dashboard.categorySecond.index', ['subCates'=>$subCates, 'cates'=>$cates]);
    }

    public function show($id)
    {
    	$cates = $this->category->all();
        $subCate = $this->cateSec->find($id);
        
        $snaps = $this->itemImg->where(['item_id'=>$id, 'type'=>4])->get();
        
        $imgCount = $this->setting->get()->first()->snap_category;
        
        return view('dashboard.categorySecond.form', ['subCate'=>$subCate, 'cates'=>$cates, 'snaps'=>$snaps, 'imgCount'=>$imgCount, 'id'=>$id, 'edit'=>1]);
    }
    
    
    public function create()
    {
    	$cates = $this->category->all();
     
     	$imgCount = $this->setting->get()->first()->snap_category;  
        
        return view('dashboard.categorySecond.form', ['cates'=>$cates, 'imgCount'=>$imgCount, ]);
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
        	'parent_id' => 'required',
            'name' => 'required|unique:category_seconds,name,'.$editId.'|max:255',
            'slug' => 'required|unique:category_seconds,slug,'.$editId.'|max:255', /* 注意:unique */
        ];
        
        $messages = [
        	'parent_id'=>'「親カテゴリー」は必須です。',
            'name.required' => '「子カテゴリー名」は必須です。',
            'name.unique' => '「子カテゴリー名」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
//        if(! isset($data['open_status'])) { //checkbox
//            $data['open_status'] = 0;
//        }

		$data['is_top'] = isset($data['is_top']) ? 1 : 0;
        

        if($editId) { //update（編集）の時
            $status = '子カテゴリーが更新されました！';
            $cateModel = $this->cateSec->find($editId);
            
            $data['updated_at'] = date('Y-m-d H:i:s', time()); //Modelにupdated_atをセットする必要がある
//            $cateModel->updated_at = date('Y-m-d H:i:s', time()); //この方法だとModelにセットする必要はない
//            $cateModel -> save();
        }
        else { //新規追加の時
            $status = '子カテゴリーが追加されました！';
            $data['view_count'] = 0;
            $cateModel = $this->cateSec;
        }
        
        $cateModel->fill($data); //モデルにセット
        $cateModel->save(); //モデルからsave
        
        $subCateId = $cateModel->id;
        
        
        // Archive img =====================================================================
        
        if(isset($data['del_mainimg']) && $data['del_mainimg']) { //削除チェックの時
            if($cateModel->main_img !== null && $cateModel->main_img != '') {
                Storage::delete($cateModel->main_img); //Storageはpublicフォルダのあるところをルートとしてみる
                $cateModel->main_img = null;
                $cateModel->save();
            }
        }
        else {
            if(isset($data['main_img'])) {
                
                //$filename = $request->file('main_img')->getClientOriginalName();
                $filename = $data['main_img']->getClientOriginalName();
                $filename = str_replace(' ', '_', $filename);
                
                //$aId = $editId ? $editId : $rand;
                //$pre = time() . '-';
                $filename = 'subcate/' . $subCateId . '/main/'/* . $pre*/ . $filename;
                //if (App::environment('local'))
                $path = $data['main_img']->storeAs('public', $filename);
                //else
                //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                $cateModel->main_img = $path;
                $cateModel->save();
            }
        }
        
        
        
        //for top-img recommend for TOP ====================================================
        if(isset($data['top_img_path'])) {
                
            //$filename = $request->file('main_img')->getClientOriginalName();
            $filename = $data['top_img_path']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            //$aId = $editId ? $editId : $rand;
            //$pre = time() . '-';
            $filename = 'subcate/' . $subCateId . '/recom/'/* . $pre*/ . $filename;
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
                
                $snapModel = $this->itemImg->where(['item_id'=>$subCateId, 'type'=>4, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                    Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる（storage/app直下）
                    $snapModel ->delete();
                }
            
            }
            else {
                if(isset($data['snap_thumb'][$count])) {
                    
                    $snapImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$subCateId, 'type'=>4, 'number'=>$count+1],
                        [
                            'item_id'=>$subCateId,
                            //'snap_path' =>'',
                            'type' => 4,
                            'number'=> $count+1,
                        ]
                    );

                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'subcate/' . $subCateId . '/snap/'/* . $pre*/ . $filename;
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
        $snaps = $this->itemImg->where(['item_id'=>$subCateId, 'type'=>4])->get();
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

        return redirect('dashboard/categories/sub/'.$subCateId)->with('status', $status);
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
        
        $this->item->where('subcate_id', $id)->get()->map(function($obj){
            $obj->subcate_id = null;
            $obj->save();
        });
        
        $cateDel = $this->cateSec->destroy($id);
        
        //if(Storage::exists('public/subcate/'. $id)) {
        	Storage::deleteDirectory('public/subcate/'. $id); //存在しなければスルーされるようだ
        //}
        
        
        $status = '子供カテゴリー「' . $name . '」';
        $status .= $cateDel ? 'が削除されました' : 'が削除出来ませんでした。';
        
        return redirect('dashboard/categories/sub')->with('status', $status);
    }
}
