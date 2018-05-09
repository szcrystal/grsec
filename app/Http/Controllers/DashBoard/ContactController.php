<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct(Admin $admin, Contact $contact)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> contact = $contact;
        
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    {
        
        $contacts = Contact::orderBy('id', 'desc')->paginate($this->perPage);
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.contact.index', ['contacts'=>$contacts,]);
    }

    public function show($id)
    {
        $contact = $this->contact->find($id);
        
        
//        $tagNames = $this->tagRelation->where(['item_id'=>$id])->get()->map(function($item) {
//            return $this->tag->find($item->tag_id)->name;
//        })->all();
//        
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
        
        return view('dashboard.contact.form', ['contact'=>$contact/*, 'cates'=>$cates, 'consignors'=>$consignors, 'tagNames'=>$tagNames, 'allTags'=>$allTags*/, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
        $cates = $this->category->all();
        $consignors = $this->consignor->all();
        
        $allTags = $this->tag->get()->map(function($item){
            return $item->name;
        })->all();
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.contact.form', ['cates'=>$cates, 'consignors'=>$consignors, 'allTags'=>$allTags]);
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
            //'movie_url' => 'required|max:255',
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
