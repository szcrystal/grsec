<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\MailTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class MailTemplateController extends Controller
{
    public function __construct(Admin $admin, MailTemplate $mailTemplate)
    {
        
        //$this -> middleware('adminauth'); //-> ORG;
        $this -> middleware(['adminauth', 'role:isAdmin']);
        
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> mailTemplate = $mailTemplate;
//        $this->category = $category;
//        $this -> tag = $tag;
//        $this->tagRelation = $tagRelation;
//        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    {

        $mailTemplates = MailTemplate::orderBy('id', 'asc')->paginate($this->perPage);
        
        //$cates= $this->category;
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.mailTemplate.index', ['mailTemplates'=>$mailTemplates  ]);
    }

    public function show($id)
    {
    	
        $mailTemplate = $this->mailTemplate->find($id);
        //$cates = $this->category->all();
        //$users = $this->user->where('active',1)->get();
        
        
        return view('dashboard.mailTemplate.form', ['mailTemplate'=>$mailTemplate, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
//        $cates = $this->category->all();
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
////        $users = $this->user->where('active',1)->get();
//        return view('dashboard.item.form', ['cates'=>$cates, 'allTags'=>$allTags]);
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
            //'title' => 'required|max:255',
            //'movie_url' => 'required|max:255',
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
//             'title.required' => '「商品名」を入力して下さい。',
//            'cate_id.required' => '「カテゴリー」を選択して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        //status
//        if(isset($data['open_status'])) { //非公開On
//            $data['open_status'] = 0;
//        }
//        else {
//            $data['open_status'] = 1;
//        }
        
        if($editId) { //update（編集）の時
            $status = 'メールテンプレートが更新されました！';
            $mail = $this->mailTemplate->find($editId);
        }
        else { //新規追加の時
            $status = 'メールテンプレートが追加されました！';
            //$data['model_id'] = 1;
            
            $mail = $this->mailTemplate;
        }
        
        $mail->fill($data);
        $mail->save();
        $mailId = $mail->id;
        
        
        return redirect('dashboard/mails/'. $mailId)->with('status', $status);
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
