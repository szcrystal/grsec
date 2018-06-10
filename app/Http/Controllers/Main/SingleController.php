<?php

namespace App\Http\Controllers\Main;

use App\Item;
use App\Category;
use App\Tag;
use App\TagRelation;
use App\ItemImage;
use App\Favorite;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class SingleController extends Controller
{
    public function __construct(Item $item, Category $category, Tag $tag, TagRelation $tagRel, ItemImage $itemImg, Favorite $favorite, User $user)
    {
        //$this->middleware('search');
        
        $this->item = $item;
        $this->category = $category;
        $this->tag = $tag;
        $this->tagRel = $tagRel;
        $this->itemImg = $itemImg;
        $this->favorite = $favorite;
        $this->user = $user;
//        $this->tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->tagGroup = $tagGroup;
//        $this->category = $category;
//        $this->item = $item;
//        $this->fix = $fix;
//        $this->totalize = $totalize;
//        $this->totalizeAll = $totalizeAll;
        
        //$this->perPage = env('PER_PAGE', 21);
        $this->itemPerPage = 15;
        
    }
    
    public function index($id)
    {
        $item = $this->item->find($id);
        
        $cateObj = $this->category->find($item->cate_id);
        
        //Other Atcl
        $otherItem = $this->item->where([ 'open_status'=>1])->whereNotIn('id', [$id])->orderBy('created_at','DESC')->take(5)->get();
        
        //Tag
        $tagRels = $this->tagRel->where('item_id', $item->id)->get()->map(function($obj){
            return $obj->tag_id;
        })->all();
        
        $tags = $this->tag->find($tagRels);
        
        //サブ画像
        $imgsPri = $this->itemImg->where(['item_id'=>$id, 'type'=>1])->orderBy('number', 'asc')->get();
        //商品画像
        $imgsSec = $this->itemImg->where(['item_id'=>$id, 'type'=>2])->orderBy('number', 'asc')->get();
        
        //お気に入り確認
        $isFav = 0;
        if(Auth::check()) {
	        $fav = $this->favorite->where(['user_id'=>Auth::id(), 'item_id'=>$id])->first();
        	
            if(isset($fav)) $isFav = 1;   
        }
        
        return view('main.home.single', ['item'=>$item, 'otherItem'=>$otherItem, 'cateObj'=>$cateObj, 'tags'=>$tags, 'imgsPri'=>$imgsPri, 'imgsSec'=>$imgsSec, 'isFav'=>$isFav]);
    }
    
    
    public function postForm(Request $request)
    {
    	$data = $request->all();
     
     	$buyItem = $this->item->find($data['item_id']);
      
         
        return view('main.cart.index', ['data'=>$data ]);
    }
    
    
    public function postCart(Request $request)
    {
    	$data = $request->all();
     
        $buyItem = $this->item->find($data['item_id']);
        
//        $per = env('TAX_PER');
//        $per = $per/100;
//        
//        $tax = floor($item->price * $per);
//        $price = $item->price + $tax;
     	
      	//$title = $this->item->find($data['item_id'])->title;   
      //ここでsessionに入れる必要がある
         
    	
        return view('main.cart.single', ['buyItem'=>$buyItem, 'tax'=>$data['tax'], 'count'=>$data['count'], 'name'=>$data['name'] ]); 
        
    }
    
    public function postScript(Request $request)
    {
        $itemId = $request->input('itemId');
        $isOn = $request->input('isOn');
        
        $user = $this->user->find(Auth::id());
        $str = '';
        
		//Favorite Save ==================================================
        //foreach($data['spare_count'] as $count) {
                        
            if(!$isOn) { //お気に入り解除の時
                $favModel = $this->favorite->where(['user_id'=>$user->id, 'item_id'=>$itemId])->first();
                
                if($favModel !== null) {
                    $favModel ->delete();
                }
                
                $str = "お気に入りから削除されました";
            }
            else {
                    
                $favModel = $this->favorite->updateOrCreate(
                    ['user_id'=>$user->id, 'item_id'=>$itemId],
                    [
                        'user_id'=>$user->id,
                        'item_id'=>$itemId,
//                            'type' => 1,
//                            'number'=> $count+1,
                    ]
                );
				
    			$str = "お気に入りに登録されました";       
            }
            
        //} //foreach
        
//        $num = 1;
//        $spares = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1])->get();
        
        //Snapのナンバーを振り直す
//        foreach($spares as $spare) {
//            $spare->number = $num;
//            $spare->save();
//            $num++;
//        }
        

        return response()->json(['str'=>$str]/*, 200*/); //200を指定も出来るが自動で200が返される  
          //return view('dashboard.script.index', ['val'=>$val]);
        //return response()->json(array('subCates'=> $subCates)/*, 200*/);
    }
    
    public function endCart()
    {
    	return view('main.cart.end');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
