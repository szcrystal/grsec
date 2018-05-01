<?php

namespace App\Http\Controllers\Main;

use App\Item;
use App\Category;
use App\Tag;
use App\TagRelation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SingleController extends Controller
{
    public function __construct(Item $item, Category $category, Tag $tag, TagRelation $tagRel)
    {
        //$this->middleware('search');
        
        $this->item = $item;
        $this->category = $category;
        $this->tag = $tag;
        $this->tagRel = $tagRel;
        //$this->fix = $fix;
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
        
        
        return view('main.home.single', ['item'=>$item, 'otherItem'=>$otherItem, 'cateObj'=>$cateObj, 'tags'=>$tags]);
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
         
    	
        return view('main.cart.single', ['buyItem'=>$buyItem, 'tax'=>$data['tax'], 'count'=>$data['count'] ]); 
        
    }
    
    public function endCart()
    {
    	return view('main.cart.end');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
