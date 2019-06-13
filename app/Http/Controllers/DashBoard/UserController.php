<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\User;
use App\UserNoregist;
use App\Sale;
use App\SaleRelation;
use App\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

use Auth;

class UserController extends Controller
{
    public function __construct(Admin $admin, User $user, UserNoregist $un, Sale $sale, SaleRelation $saleRel, Item $item)
    {
        
        $this -> middleware(['adminauth', 'role:isAdmin']);
		
        //$this -> authorize('is-admin');
        //$this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> user = $user;
        $this->un = $un;
        $this->sale = $sale;
        $this->saleRel = $saleRel;
        $this->item = $item;
//        $this->category = $category;
//        $this -> tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->consignor = $consignor;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index(Request $request)
    {

        if($request->has('no_r')) {
        	$model = $this->un;
         	$isUser = 0;  
        }
        else {
        	$model = $this->user;
         	$isUser = 1;   
        }
        
        //$userObjs = $model->orderBy('id', 'desc')->paginate($this->perPage);
        $userObjs = $model->orderBy('id', 'desc')->get();
        
        //$cates= $this->category;
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.user.index', ['userObjs'=>$userObjs, 'isUser'=>$isUser, ]);
    }

    public function show($id, Request $request)
    {
            
    	if($request->has('no_r')) {
            $model = $this->un;
            $isUser = 0;
        }
        else {
            $model = $this->user;
            $isUser = 1;   
        }
        
        $user = $model->find($id);
        
        $itemModel = $this->item;
        
        
        $relIds = $this->saleRel->where(['user_id'=>$user->id, 'is_user'=>$isUser])->get()->map(function($obj) {
        	return $obj->id;
        })->all();
        
//        print_r($relIds);
//        exit;
        
        $sales = $this->sale->whereIn('salerel_id', $relIds)->orderBy('id', 'desc')->paginate($this->perPage);
//        print_r($sales);
//        exit;
        
//        $cates = $this->category->all();
//        $consignors = $this->consignor->all();
//        //$users = $this->user->where('active',1)->get();
//        
//        $tagNames = $this->tagRelation->where(['item_id'=>$id])->get()->map(function($item) {
//            return $this->tag->find($item->tag_id)->name;
//        })->all();
//        
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
        
        return view('dashboard.user.form', ['user'=>$user, 'isUser'=>$isUser, 'sales'=>$sales, 'itemModel'=>$itemModel, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
        $cates = $this->category->all();
        $consignors = $this->consignor->all();
        
        $allTags = $this->tag->get()->map(function($item){
            return $item->name;
        })->all();
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.item.form', ['cates'=>$cates, 'consignors'=>$consignors, 'allTags'=>$allTags]);
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
            'title' => 'required|max:255',
            'cate_id' => 'required',
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
             'title.required' => '「商品名」を入力して下さい。',
            'cate_id.required' => '「カテゴリー」を選択して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        //status
        if(isset($data['open_status'])) { //非公開On
            $data['open_status'] = 0;
        }
        else {
            $data['open_status'] = 1;
        }
        
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
            $filename = 'item/' . $itemId . '/thumbnail/'/* . $pre*/ . $filename;
            //if (App::environment('local'))
            $path = $data['main_img']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
            
            $item->main_img = $path;
            $item->save();
        }
        
        //Spare-img
        if(isset($data['spare_img'])) {
            $spares = $data['spare_img'];
            
//            print_r($spares);
//            exit;
            
            foreach($spares as $key => $spare) {
                if($spare != '') {
            
                    $filename = $spare->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'item/' . $itemId . '/thumbnail/'/* . $pre*/ . $filename;
                    //if (App::environment('local'))
                    $path = $spare->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                    
                    //$item->spare_img .'_'. $ii = $path;
                    $item['spare_img_'. $key] = $path;
                    $item->save();
                }

            }
        }
        
        //spare画像の削除
        if(isset($data['del_spareimg'])) {
            $dels = $data['del_spareimg'];     
             
              foreach($dels as $key => $del) {
                   if($del) {
                     $imgName = $item['spare_img_'. $key];
                       if($imgName != '') {
                         Storage::delete($imgName);
                     }
                    
                       $item['spare_img_'. $key] = '';
                    $item->save();
                 }   
           }
        }
        

        
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
                /*
                $tagRel = $this->tagRelation->where(['tag_id'=>$tagId, 'item_id'=>$itemId])->get();
                if($tagRel->isEmpty()) {
                    $this->tagRelation->create([
                        'tag_id' => $tagId,
                        'item_id' => $itemId,
                    ]);
                }
                */

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
        
        
        return redirect('dashboard/items/'. $itemId)->with('status', $status);
    }

    
    public function edit($id)
    {
        return redirect('dashboard/items/'.$id);
    }

    
    public function getCsv(Request $request)
    {

        $vals = [
        	'id',
            'name',
            'email',
            'hurigana',
            'gender',
            'birth_year',
            'birth_month',
            'birth_day',
            'post_num',
            'prefecture',
            'address_1',
            'address_2',
            'address_3',
            'tel_num',
            'magazine',
            'point',
            'created_at',
            //'updated_at',
        
        ];
        
        $keys = [
        	'id',
            'お名前',
            'メールアドレス',
            'フリガナ',
            '性別',
            '生年月日(年)',
            '生年月日(月)',
            '生年月日(日)',
            '郵便番号',
            '都道府県',
            '住所1',
            '住所2',
            '住所3',
            '電話番号',
            'メルマガ登録',
            'ポイント',
            '登録日',  
        
        ];

        
		if($request->has('no_r')) {
        	$users = $this->un->all($vals)->toArray();
            $fileName = 'gr-nouser_'. date('Ymd', time()) .'.csv';
        }
        else {
			$users = $this->user->all($vals)->toArray();
            $fileName = 'gr-user_'. date('Ymd', time()) .'.csv';
        }
        //array_splice($keys, 9, 0, '価格(税込)'); //追加項目 keyに追加
        
        //$taxPer = $this->setting->get()->first()->tax_per;
        
        $alls = array();
        foreach($users as $user) {

//            $item['cate_id'] = $this->category->find($item['cate_id'])->name;
//            $item['subcate_id'] = $this->categorySecond->find($item['subcate_id'])->name;
//            
//            $item['consignor_id'] = $this->consignor->find($item['consignor_id'])->name;
//            $item['dg_id'] = $this->dg->find($item['dg_id'])->name;
            
//            $priceWithTax = $item['price'] + ($item['price'] * $taxPer/100);
//            array_splice($item, 9, 0, $priceWithTax); //追加項目 key名は0になるが関係ないので
            
            $alls[] = $user;
//            print_r($item);
//        	exit;
        }
        
        array_unshift($alls, $keys); //先頭にヘッダー(key)を追加
        
        //$items = $items->toArray();
//        print_r($alls);
//        exit;

		//$fileName = $request->has('no_r') ? 'gr-nouser.csv' : 'gr-user.csv';
        
        try {
        	return  new StreamedResponse(
                function () use($alls) {
            

                    $stream = fopen('php://output', 'w');
                    
                    //mb_convert_variables('UTF-8', "ASCII,UTF-8,SJIS-win", $alls);
                    //fputcsv($stream, $keys);
                    
                    foreach ($alls as $line) {
                        //mb_convert_variables('UTF-8', "ASCII,UTF-8,SJIS-win", $line);
                        fputcsv($stream, $line);
                    }
                    fclose($stream);
                },
                200,
                [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="'. $fileName .'"',
                ]
            );
        }
        catch (Exception  $e) {
              //DB::rollback();
              unlink($this->csvFilePath);
              throw $e;
              print_r($e);
              exit;
        }
        
    }
    
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
