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
        $cates = Category::orderBy('id', 'desc')
           //->take(10)
           ->paginate($this->perPage);
        
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
        
        $cateId = $cateModel->id;
        
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
                //echo $count . '/' .$data['del_snap'][$count];
                //exit;
                
                $snapModel = $this->itemImg->where(['item_id'=>$cateId, 'type'=>3, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                	Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
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
