<?php

namespace App\Http\Controllers\DashBoard;

use App\Fix;
use App\Setting;
use App\ItemImage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class FixController extends Controller
{
    public function __construct(Fix $fix, Setting $setting, ItemImage $itemImg)
    {
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> fix = $fix;
        $this->setting = $setting;
        $this->set = $this->setting->get()->first();
        
        $this->itemImg = $itemImg;
        
        $this->perPage = 20;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fixes = Fix::orderBy('id', 'desc')->paginate($this->perPage);
        
        return view('dashboard.fix.index', ['fixes'=>$fixes]);
    }

    public function show($id)
    {
        $fix = $this->fix->find($id);
        
        $snaps = $this->itemImg->where(['item_id'=>$id, 'type'=>7])->get();
        $imgCount = $this->set->snap_fix;
        
        return view('dashboard.fix.form', ['fix'=>$fix, 'id'=>$id, 'snaps'=>$snaps, 'imgCount'=>$imgCount, 'edit'=>1]);
    }
    
    public function create()
    {
        $imgCount = $this->set->snap_fix;
        
        return view('dashboard.fix.form', ['imgCount'=>$imgCount,]);
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
        
        $exceptId = $editId ? ','. $editId : '';
        $rules = [
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:fixes,slug'.$exceptId,
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        $data['open_status'] = isset($data['open_status']) ? 0 : 1;
        
        
        //$data['up_date'] = $request->input('up_year'). '-' .$request->input('up_month') . '-' . $request->input('up_day');
//        $data['up_date'] = '2017-01-01 11:11:11';
//        $data['sumbnail'] = '/images/abc.jpg';
//        $data['sumbnail_url'] = 'http://example.com';
        
//        foreach($data as $key=>$val) { //checkboxの複数選択をカンマ区切りにする
//            if(is_array($val))
//                $data[$key] = implode(',', $val);
//        }
        
        //tagのチェックが一つもされていない時、Undefinedになるので空をセットする
//        $n = 0;
//        while ($n < 3) {
//            $name = 'tag_'.($n+1);
//            if(!isset($data[$name]))
//                $data[$name] = '';
//            
//            $n++;
//        }

        if($editId) { //update（編集）の時
            $fixModel = $this->fix->find($editId);
            $status = '固定ページが更新されました！';
        }
        else { //新規追加の時
            $status = '固定ページが追加されました！';
            $fixModel = $this->fix;
        }
        
        $fixModel->fill($data); //モデルにセット
        $fixModel->save(); //モデルからsave
        
        $fixId = $fixModel->id;
        
        //Snap Save ==================================================
        foreach($data['snap_count'] as $count) {
        
            /*
                type:1-> item main
                type:2-> item spare
                type:3-> category
                type:4-> sub category
                type:5-> tag 
                type:6-> top carousel
                type:7-> fix                           
            */         
 
            if(isset($data['del_snap'][$count]) && $data['del_snap'][$count]) { //削除チェックの時
                //echo $count . '/' .$data['del_snap'][$count];
                //exit;
                
                $snapModel = $this->itemImg->where(['item_id'=>$fixId, 'type'=>7, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                	Storage::delete('public/'. $snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $snapModel ->delete();
                }
            
            }
            else {
                if(isset($data['snap_thumb'][$count])) {
                    
                    $snapImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$fixId, 'type'=>7, 'number'=>$count+1],
                        [
                            'item_id'=>$fixId,
                            //'snap_path' =>'',
                            'type' => 7,
                            'number'=> $count+1,
                        ]
                    );

                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'fix/' . $fixId . '/snap/'/* . $pre*/ . $filename;
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
        
        
        //Snapのナンバーを振り直す
        $num = 1;
        $snaps = $this->itemImg->where(['item_id'=>$fixId, 'type'=>7])->get();
        
        foreach($snaps as $snap) {
            $snap->number = $num;
            $snap->save();
            $num++;
        }
        
        //Snap END ===========================================
        
        //return view('dashboard.article.form', ['thisClass'=>$this, 'tags'=>$tags, 'status'=>'記事が更新されました。']);
        return redirect('dashboard/fixes/'. $fixId)->with('status', $status);

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
        $fix = $this->fix->find($id);
        
//        $atcls = $this->item->where('cate_id', $id)->get()->map(function($item){
//            $item->cate_id = 0;
//            $item->save();
//        });
        
        $fixDel = $this->fix->destroy($id);
        
        //if(Storage::exists('public/subcate/'. $id)) {
        	Storage::deleteDirectory('public/fix/'. $id); //存在しなければスルーされるようだ
        //}
        
        $status = $fixDel ? '「'.$fix->title.'」ページが削除されました。' : '「'.$fix->title.'」ページが削除出来ませんでした。';
        
        return redirect('dashboard/fixes')->with('status', $status);
    }
    
//    $name = $this->tag->find($tagId)->name;
//        
//        //tag relationをここで消す
//        $tagRels = $this->tagRel->where('tag_id', $tagId)->get()->map(function($obj){
//            return $obj->id;
//        })->all();
//        
//        $tagDel = $this->tag->destroy($tagId);
//        $this->tagRel->destroy($tagRels);
//        
//        //if(Storage::exists('public/subcate/'. $id)) {
//        	Storage::deleteDirectory('public/tag/'. $tagId); //存在しなければスルーされるようだ
//        //}
//        
//        $status = $tagDel ? 'タグ「'.$name.'」が削除されました' : 'タグ「'.$name.'」が削除出来ませんでした';
//        
//        return redirect('dashboard/tags')->with('status', $status);
    
    
    
}
