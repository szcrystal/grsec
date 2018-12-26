<?php
//    print_r($upperRelArr);
//    exit;

    $chunkNum = 0;
?>

<div class="upper-wrap">
    
    @foreach($upperRelArr as $blockKey => $upperRels)
        <?php
            //ここでのblockKeyは [a],[b],[c]
            $chunkNum++;
            $chunkNumArr = ['a'=>1, 'b'=>3, 'c'=>3];     
        ?>
        
        <div class="block-wrap">

            @foreach($upperRels as $key => $upperRel)
            
                <?php
                    //ここでのkeyは [section], [mid_section], [block]
                ?>
                
                @if($key === 'mid_section')
                	<?php continue; ?>
                    
                @elseif($key === 'section')
                    
                    @if($upperRel->title != '')
                        <h3>{!! $upperRel->title !!}</h3>
                    @endif
                    
                @else
                    <div class="{{ $blockKey }}-block-wrap clearfix">

                        <?php
                            //chunkNumはroopでカウント。a->1, b->2, c->3でchunkする
                            //$chunks = array_chunk($upperRel, $chunkNum);
                            
                        	$chunks = array();
                            $chunks = array_chunk($upperRel, $chunkNumArr[$blockKey]);
                            
//                            if($blockKey === 'a') 
//                                $chunks = array_chunk($upperRel, 1);
//                            elseif($blockKey === 'b') 
//                                $chunks = array_chunk($upperRel, 3);
//                            elseif($blockKey === 'c') 
//                                $chunks = array_chunk($upperRel, 3);
                        ?>
                        
                        
                        @foreach($chunks as $chunkKey => $chunk)
                        	
                            @if(isset($upperRels['mid_section'][$chunkKey]) && $upperRels['mid_section'][$chunkKey]->title != '')
                                <h4>{{ $upperRels['mid_section'][$chunkKey]->title }}</h4>
                            @endif
                            
                            
                            <div class="clearfix">
 
                                @foreach($chunk as $uRel)
                                    
                                    @if(!isset($uRel->img_path) && !isset($uRel->title) && !isset($uRel->detail))
                                        <?php
                                        	continue;
                                        ?>
                                    @endif
                                    
                                    <div class="{{ $blockKey }}-block clearfix ">

                                        @if(isset($uRel->img_path))
                                            <div class="img-wrap">
                                            	@if(isset($uRel->url))
                                                	<a href="{{ $uRel->url }}">
                                                		<img src="{{ Storage::url($uRel->img_path) }}" class="w-100">
                                                    </a>
                                                @else
                                                	<img src="{{ Storage::url($uRel->img_path) }}" class="w-100">
                                                @endif
                                            </div>
                                        @endif
                                        
                                        @if(isset($uRel->title) || isset($uRel->detail))
                                            <div class="detail-wrap">
                                                @if(isset($uRel->title))
                                                    <h5>
                                                    	@if(isset($uRel->url))
                                                			<a href="{{ $uRel->url }}">{{ $uRel->title }}</a>
                                                        @else
                                                        	{{ $uRel->title }}
                                                        @endif
                                                    </h5>
                                                @endif
                                                
                                                @if(isset($uRel->detail))
                                                    <div>
                                                        {!! nl2br($uRel->detail) !!}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                    </div>
                                @endforeach
                                
                            </div>
                        @endforeach
                         
                    </div>
                @endif
                
            @endforeach
            
        </div>
        
    @endforeach
</div>


