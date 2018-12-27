<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\MailMagazine;
use App\Setting;
use App\User;
use App\UserNoregist;
use App\Sale;


use App\Jobs\ProcessMagazine;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;

use App\Mail\Magazine;

//use Artisan;

//use App\Item;
//use App\Jobs\ProcessFollowMail;
use DateTime;
//use App\SaleRelation;


class MailMagazineController extends Controller
{
    public function __construct(Admin $admin, MailMagazine $mag, Setting $setting, User $user, UserNoregist $noReg)
    {
        
        $this -> middleware(['adminauth', 'role:isAdmin']);
        //$this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> mag = $mag;
        
        $this->setting = $setting;
        
        $this->user = $user;
        $this->noReg = $noReg;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    {
        
            
        //$itemObjs = Item::orderBy('id', 'desc')->paginate($this->perPage);
        $magObjs = $this->mag->orderBy('id', 'desc')->get();
        
//        $cates= $this->category;
//        $subCates= $this->categorySecond;
//        $dgs = $this->dg;
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.magazine.index', ['magObjs'=>$magObjs/*, 'cates'=>$cates, 'subCates'=>$subCates, 'dgs'=>$dgs*/]);
    }

    public function show($id)
    {
    	
            
        $mag = $this->mag->find($id);
//        $cates = $this->category->all();
//        $subcates = $this->categorySecond->where(['parent_id'=>$item->cate_id])->get();
//        $consignors = $this->consignor->all();
//        $dgs = $this->dg->all();
//        
//        $spares = $this->itemImg->where(['item_id'=>$id, 'type'=>1])->get();
//        $snaps = $this->itemImg->where(['item_id'=>$id, 'type'=>2])->get();
//        
//        //$users = $this->user->where('active',1)->get();
//        
//		$tagNames = $this->tagRelation->where(['item_id'=>$id])->get()->map(function($item) {
//            return $this->tag->find($item->tag_id)->name;
//        })->all();
//        
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
//        
//        $setting = $this->setting->get()->first();
//        $primaryCount = $setting->snap_primary;
//        $imgCount = $setting->snap_secondary;
        
        return view('dashboard.magazine.form', ['mag'=>$mag, /*'cates'=>$cates, 'subcates'=>$subcates, 'consignors'=>$consignors, 'dgs'=>$dgs, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'spares'=>$spares, 'snaps'=>$snaps, 'primaryCount'=>$primaryCount, 'imgCount'=>$imgCount,*/ 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
    	
            
            
//        $cates = $this->category->all();
//        $consignors = $this->consignor->all();
//        $dgs = $this->dg->all();
//        
//        $allTags = $this->tag->get()->map(function($item){
//        	return $item->name;
//        })->all();
//        
//        $setting = $this->setting->get()->first();
//        $primaryCount = $setting->snap_primary;
//        $imgCount = $setting->snap_secondary;
        
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.magazine.form', [/*'cates'=>$cates, 'consignors'=>$consignors, 'dgs'=>$dgs, 'allTags'=>$allTags, 'primaryCount'=>$primaryCount, 'imgCount'=>$imgCount, */]);
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
        	'number' => 'required|unique:items,number,'.$editId.'|numeric',
            'title' => 'required|max:255',
            'cate_id' => 'required',
            'dg_id' => 'required',
            'factor' => 'required|numeric',
            
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'stock' => 'nullable|numeric',
            'point_back' => 'nullable|numeric',
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
         	'title.required' => '「商品名」を入力して下さい。',
            'cate_id.required' => '「カテゴリー」を選択して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        //$this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
  
//        $current = new DateTime('now'); 
//        $from = new DateTime('2018-04-09 04:13:44');
//        $diff = $current->diff($from);
//            
//        echo $diff->days;
//        exit;
        
/* *******************************************: 
			$sales = Sale::get();
            $ensureSales = array();
            
            $ensure_7 = array();
            $ensure_33 = array();
            $ensure_96 = array();
            $ensure_155 = array();
            
            $noEnsure_33 = array();
            
            $current = new DateTime('now'); 
            
            foreach($sales as $sale) {
                
                //$d = strtotime($sale->deli_start_date);
                $from = new DateTime($sale->deli_start_date);
                $diff = $current->diff($from);
                
                $ensure = Item::find($sale->item_id)->is_ensure;
                
                if($ensure) {
                    if($diff->days == 7) {
                        $ensure_7[$sale->salerel_id][] = $sale;
                    }
                    elseif($diff->days == 33) {
                        $ensure_33[$sale->salerel_id][] = $sale;
                    }
                    elseif($diff->days == 96) {
                        $ensure_96[$sale->salerel_id][] = $sale;
                    }
                    elseif($diff->days == 155) {
                        $ensure_155[$sale->salerel_id][] = $sale;
                    }
                }
                else {
                    if($diff->days == 33) {
                        $noEnsure_33[$sale->salerel_id][] = $sale;
                    }
                }
                

    //        $limitDay = new DateTime(date('Y-m-d', $limit));
    //        $current = new DateTime('now');
    //        $diff = $current->diff($limitDay);       
    //        return ['limit'=>date('Y/m/d', $limit), 'diffDay'=>$diff->days];

            }
    //        print_r($saleForMail);
    //        exit;
    
//    		foreach($ensure_33 as $relIdKey => $saleArr) {
//            
//                //$data = array();
//                
//                foreach($saleArr as $sale) {
//                    $saleRel = SaleRelation::find($sale->salerel_id);
//                    
//                    if($saleRel->is_user) {
//                        $u = User::find($saleRel->user_id);
//                    }
//                    else {
//                        $u = UserNoregist::find($saleRel->user_id);
//                    }
//                    
//                    $mailAdd = $u->email;
//                    $name = $u->name;
//                    
//                    break;
//                    
//                    //$item = Item::find($sale->item_id);
//                }
//            }
//            
//            echo $mailAdd . $name;
//            exit;

            if(count($ensure_7) > 0) {
                ProcessFollowMail::dispatch($ensure_7, 7, true);
            }
            
            if(count($ensure_33) > 0) {
                ProcessFollowMail::dispatch($ensure_33, 33, true);
            }
            
            if(count($ensure_96) > 0) {
                ProcessFollowMail::dispatch($ensure_96, 96, true);
            }
            
            if(count($ensure_155) > 0) {
                ProcessFollowMail::dispatch($ensure_155, 155, true);
            }
            
            if(count($noEnsure_33) > 0) {
                ProcessFollowMail::dispatch($noEnsure_33, 33, false);
            }
            
            
            
        
        print_r($ensure_33);
        exit;
******************************************* 
*/       
    
            
        
        //stock_show
        $data['is_send'] = isset($data['with_mail']) ? 1 : 0;
        $data['send_date'] = date('Y-m-d H:i:s', time());
        
        if($editId) { //update（編集）の時
            $mag = $this->mag->find($editId);
        }
        else { //新規追加の時
            //$data['model_id'] = 1;
            
            $mag = $this->mag;
        }
        
        $status = $data['is_send'] ? 'メールマガジンが送信されました！' : 'メールマガジンが更新されました！';
        
        $mag->fill($data);
        $mag->save();
        $magId = $mag->id;
        
        
        if($data['is_send']) {
        
            $users = array();
//            $userArr = array();
//            $noUserArr = array();
            
            //from User
            $userMag = $this->user->where('magazine', 1)->get();
            
            foreach($userMag as $val) {
                $users['user'][$val->id] = $val->email;
            }
            
            //from NoUser
//            $noUserMag = $this->noReg->whereNotIn('active', [2])->where('magazine', 1)->get(); //active:2 -> 退会者
//            
//            foreach($noUserMag as $value) {
//                $users['noUser'][$value->id] = $value->email;
//            }
            
    
//    		print_r($users);
//            echo count($users);
//            exit;
            
            //****** Dispatchの方法(1dispatchで1データ)　job DBのidは少なく済む　php artisant queue:workの指定でtimeout=600が必要（ローカルのポートブロックが原因で遅くなるためなので本番では不要）
            ProcessMagazine::dispatch($users['user'], $data, 1); /*->onQueue('magazine')*/
            //ProcessMagazine::dispatch($users['noUser'], $data, 0)->delay(now()->addMinutes(5));
            //Artisan::call('queue:work', ['timeout'=>600]);
            
            //****** 1通ごとに直接キューに入れる方法 こちらの方が少し早いかも 1キュー1データなのでJob DBのidがかなりの数になる artisan queue:workでtimeout指定はなくても進む
//            foreach($users as $key => $mailArr) {
//            	$uModel = ($key == 'user') ? $this->user : $this->noReg;
//                
//                foreach($mailArr as $userIdKey => $mailVal) {
//                    $data['name'] = $uModel->find($userIdKey)->name;
//                    
//                    //Mail::to($mailVal, $data['name'])->queue(new Magazine($data));
//                    Mail::to($mailVal, $data['name'])->send(new Magazine($data));
//                }
//            }
            
        
        }
        
        
        return redirect('dashboard/magazines/'. $magId)->with('status', $status);
        
/*
        //status
        $data['open_status'] = isset($data['open_status']) ? 0 : 1;
        
        //stock_show
        $data['is_delifee'] = isset($data['is_delifee']) ? 1 : 0;
        $data['stock_show'] = isset($data['stock_show']) ? 1 : 0;
        $data['farm_direct'] = isset($data['farm_direct']) ? 1 : 0;
        $data['is_once'] = isset($data['is_once']) ? 1 : 0;
        $data['is_delifee_table'] = isset($data['is_delifee_table']) ? 1 : 0;
        
        
        if($editId) { //update（編集）の時
            $status = '商品が更新されました！';
            $item = $this->item->find($editId);
        }
        else { //新規追加の時
            $status = '商品が追加されました！';
            //$data['model_id'] = 1;
            
            $item = $this->item;
        }
        
        $item->fill($data);
        $item->save();
        $itemId = $item->id;
        
//        print_r($data['main_img']);
//        exit;
        
        //Main-img
        if(isset($data['main_img'])) {
                
            //$filename = $request->file('main_img')->getClientOriginalName();
            $filename = $data['main_img']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            //$aId = $editId ? $editId : $rand;
            //$pre = time() . '-';
            $filename = 'item/' . $itemId . '/main/' . $filename;
            //if (App::environment('local'))
            $path = $data['main_img']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
            
            $item->main_img = $path;
            $item->save();
        }

        
        //SpareImg Save ==================================================
        foreach($data['spare_count'] as $count) {
                        
            if(isset($data['del_spare'][$count]) && $data['del_spare'][$count]) { //削除チェックの時
                
                $spareModel = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1])->first();
                
                if($spareModel !== null) {
                	Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $spareModel ->delete();
                }
            
            }
            else {
            	if(isset($data['spare_thumb'][$count])) {
                    
                    $spareImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1],
                        [
                            'item_id'=>$itemId,
                            'type' => 1,
                            'number'=> $count+1,
                        ]
                    );
                
                
                    $filename = $data['spare_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'item/' . $itemId . '/spare/' . $filename;
                    //if (App::environment('local'))
                    $path = $data['spare_thumb'][$count]->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    //$data['model_thumb'] = $filename;
                    
                    $spareImg->img_path = $filename;
                    $spareImg->save();
                }
            }
            
        } //foreach
        
        $num = 1;
        $spares = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1])->get();
        
        //Snapのナンバーを振り直す
        foreach($spares as $spare) {
            $spare->number = $num;
            $spare->save();
            $num++;
        }
*/        
        //Spare END ===========================================
        
        

/*        
        //タグのsave動作
        if(isset($data['tags'])) {
            $tagArr = $data['tags'];
        
            foreach($tagArr as $tag) {
                
                //Tagセット
                $setTag = Tag::firstOrCreate(['name'=>$tag]); //既存を取得 or なければ作成
                
                if(!$setTag->slug) { //新規作成時slugは一旦NULLでcreateされるので、その後idをセットする
                    $setTag->slug = $setTag->id;
                    $setTag->save();
                }
                
                $tagId = $setTag->id;
                $tagName = $tag;


                //tagIdがRelationになければセット ->firstOrCreate() ->updateOrCreate()
                $tagRel = $this->tagRelation->firstOrCreate(
                    ['tag_id'=>$tagId, 'item_id'=>$itemId]
                );
                
//                $tagRel = $this->tagRelation->where(['tag_id'=>$tagId, 'item_id'=>$itemId])->get();
//                if($tagRel->isEmpty()) {
//                    $this->tagRelation->create([
//                        'tag_id' => $tagId,
//                        'item_id' => $itemId,
//                    ]);
//                }
//                

                //tagIdを配列に入れる　削除確認用
                $tagIds[] = $tagId;
            }
        
            //編集時のみ削除されたタグを消す
            if(isset($editId)) {
                //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合をin_arrayにて確認
                $tagRels = $this->tagRelation->where('item_id', $itemId)->get();
                
                foreach($tagRels as $tagRel) {
                    if(! in_array($tagRel->tag_id, $tagIds)) {
                        $tagRel->delete();
                    }
                }
            }
        }
*/       
        
        
        
        
    }

	public function postScript(Request $request)
    {
        $cate_id = $request->input('selectValue');
        
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
        
        $subCates = $this->categorySecond->where(['parent_id'=>$cate_id, ])->get()->map(function($obj) {
        	return [ $obj->id => $obj->name ];
        })->all();
        
        //$array = [1, 11, 12, 13, 14, 15];
         
        return response()->json(array('subCates'=> $subCates)/*, 200*/); //200を指定も出来るが自動で200が返される  
          //return view('dashboard.script.index', ['val'=>$val]);
    }

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
