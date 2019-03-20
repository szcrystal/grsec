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
        $this -> middleware(['adminauth', 'role:isAdmin']);
        //$this -> middleware('adminauth');
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
        
        $contacts = Contact::orderBy('id', 'desc')->get();
        
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
        
//        $rules = [
//            'title' => 'required|max:255',
//            //'movie_url' => 'required|max:255',
//            //'main_img' => 'filenaming',
//        ];
//        
//         $messages = [
//            'title.required' => '「商品名」を入力して下さい。',
//            'cate_id.required' => '「カテゴリー」を選択して下さい。',
//        ];
//        
//        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        //status
        $status = isset($data['status']) ? 1 : 0;
        
        
        if($editId) { //update（編集）の時
            $status = '更新されました！';
            $contact = $this->contact->find($editId);
        }
        else { //新規追加の時
            $status = '商品が追加されました！';
            //$data['model_id'] = 1;
            
            $item = $this->item;
        }
        
        $contact->fill($data);
        $contact->save();
        $cId = $contact->id;
        
        
        return redirect('dashboard/contacts/'. $cId)->with('status', $status);
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
