<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Setting;
use App\ItemImage;
use App\TopSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;

class TopSettingController extends Controller
{
    public function __construct(Admin $admin, Setting $setting, ItemImage $itemImg, TopSetting $topSet/*, Item $item, Tag $tag, Category $category, TagRelation $tagRelation*/)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this -> setting = $setting;
        $this->itemImg = $itemImg;
        $this->topSet = $topSet;
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
        
        $setting = $this->topSet->first(); //->paginate($this->perPage);
        
//        print_r($setting);
//        exit;
        
        //$cates= $this->category;
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        $snaps = $this->itemImg->where(['item_id'=>9999, 'type'=>6])->get();
        $imgCount = $this->setting->get()->first()->snap_top;
        
        return view('dashboard.topSetting.form', ['setting'=>$setting, 'imgCount'=>$imgCount, 'snaps'=>$snaps, 'edit_id'=>1]);
    }

//    public function show($id)
//    {
//        $consignor = $this->consignor->find($id);
//        //$cates = $this->category->all();
//        //$users = $this->user->where('active',1)->get();
//        
//        
//        return view('dashboard.consignor.form', ['consignor'=>$consignor, 'id'=>$id, 'edit'=>1]);
//    }
   
//    public function create()
//    {
////        $cates = $this->category->all();
////        $allTags = $this->tag->get()->map(function($item){
////            return $item->name;
////        })->all();
////        $users = $this->user->where('active',1)->get();
//        return view('dashboard.consignor.form', [/*'cates'=>$cates, 'allTags'=>$allTags*/]);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
        $rules = [
//            'admin_name' => 'required|max:255',
//            'admin_email' => 'required|max:255',
//            'tax_per' => 'required|numeric',
//            'sale_per' => 'required_with:is_sale|nullable|numeric',
//            'kare_ensure' => 'required|numeric',
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
            // 'name.required' => '「出荷元名」を入力して下さい。',
            //'sale_per.required_with' => '「割引率」を指定して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        //status
//		$data['is_product'] = isset($data['is_product']) ? $data['is_product'] : 0;
//        $data['is_sale'] = isset($data['is_sale']) ? $data['is_sale'] : 0;
//            $data['open_status'] = 0;
//        }
//        else {
//            $data['open_status'] = 1;
//        }
        
        //if($editId) { //update（編集）の時
            $status = 'TOP設定が更新されました！';
            //$setting = $this->setting->first();
            $setting = $this->topSet->firstOrCreate(['id'=>1]);
//        }
//        else { //新規追加の時
//            $status = '出荷元が追加されました！';
//            //$data['model_id'] = 1;
//            
//            $setting = $this->setting;
//        }
        
        $setting->fill($data);
        $setting->save();
        //$settingId = $setting->id;
        
        
        //Snap Save ==================================================
        foreach($data['snap_count'] as $count) {
        
            /*
                type:1->item main
                type:2->item spare
                type:3->category
                type:4->sub category
                type:5->tag
                type:6->top carousel                            
            */         
 
            if(isset($data['del_snap'][$count]) && $data['del_snap'][$count]) { //削除チェックの時
                
                $snapModel = $this->itemImg->where(['item_id'=>9999, 'type'=>6, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                    Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $snapModel ->delete();
                }
            
            }
            else {
                if(isset($data['snap_thumb'][$count])) {
                    
                    $snapImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>9999, 'type'=>6, 'number'=>$count+1],
                        [
                            'item_id'=>9999,
                            //'snap_path' =>'',
                            'type' => 6,
                            'number'=> $count+1,
                        ]
                    );

                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'top/' . 9999 . '/snap/'/* . $pre*/ . $filename;
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
        $snaps = $this->itemImg->where(['item_id'=>9999, 'type'=>6])->get();
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
        
        return redirect('dashboard/top-settings')->with('status', $status);
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
