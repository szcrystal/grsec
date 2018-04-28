<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
    
use Auth;

class MainController extends Controller
{
    public function __construct(Admin $admin/*, Tag $tag, Article $article, Totalize $totalize*/)
    {
        
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
//        //$this->middleware('auth:admin', ['except' => 'getLogout']);
//        //$this -> middleware('log', ['only' => ['getIndex']]);
//        
        $this -> admin = $admin;
//        $this-> article = $article;
//        $this -> totalize = $totalize;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
    }
    
    
    public function index()
    {
    	$adminUser = Auth::guard('admin')->user();
     	   
        return view('dashboard.index', ['name'=>$adminUser->name]);
    }

    public function getRegister ($id='')
    {
        $editId = 0;
        $admin = NULL;
        
        if($id) {
            $editId = $id;
            $admin = $this->admin->find($id);
        }
        
        $admins = $this->admin->paginate($this->perPage);
        
        return view('dashboard.register', ['admins'=>$admins, 'admin'=>$admin, 'editId'=>$editId]);
    }
    
    public function postRegister(Request $request)
    {
        $editId = $request->input('edit_id');
        $valueId = '';
        if($editId) {
            $valueId = ','. $editId;
        }
        
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email'.$valueId, /* |unique:admins 注意:unique */
            'password' => 'required|min:8',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if($data['edit_id']) {
            $adminModel = $this->admin->find($data['edit_id']);
        }
        else {
            $adminModel = $this->admin;
        }
        
        $data['password'] = bcrypt($data['password']);
        
        $adminModel->fill($data);
        $adminModel->save();
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//        $admin = Admin::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//            //'admin' => 99,
//        ]);
        
        if($editId)
            $status = '管理者情報を更新しました！';
        else
            $status = '管理者:'.$data['name'].'さんが追加されました。';
        
        return redirect('dashboard/register')->with('status', $status);
    }
    
    
    public function getLogout(Request $request) {
        //$request->session()->pull('admin');
        Auth::guard('admin')->logout();
        return redirect('dashboard/login'); //->intended('/')
    }
}