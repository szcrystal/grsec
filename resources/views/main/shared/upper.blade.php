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
        ?>
        
        <div class="block-wrap">

            @foreach($upperRels as $key => $upperRel)
            
                <?php
                    //ここでのkeyは [section], [block]
                ?>
                
                @if($key === 'section')
                    
                    @if($upperRel->title != '')
                        <h3>{!! $upperRel->title !!}</h3>
                    @endif
                    
                @else
                    <div class="{{ $blockKey }}-block-wrap clearfix">

                        <?php
                            //chunkNumはroopでカウント。a->1, b->2, c->3でchunkする
                            $chunks = array_chunk($upperRel, $chunkNum);
                            
//                          if($blockKey === 'a') 
//                              $chunks = array_chunk($upperRel, 1);
//                          elseif($blockKey === 'b') 
//                              $chunks = array_chunk($upperRel, 2);
//                          elseif($blockKey === 'c') 
//                              $chunks = array_chunk($upperRel, 3);
                        ?>
                        
                        @foreach($chunks as $chunk)
                            <div class="clearfix">
                                
                                @foreach($chunk as $uRel)
                                	@if(!isset($uRel->img_path) && !isset($uRel->title) && !isset($uRel->detail))
                                        <?php
                                        	continue;
                                        ?>
                                    @endif
                                    
                                    <div class="{{ $blockKey }}-block clearfix">

                                        @if(isset($uRel->img_path))
                                            <div class="img-wrap">
                                                <img src="{{ Storage::url($uRel->img_path) }}" class="w-100">
                                            </div>
                                        @endif
                                        
                                        @if(isset($uRel->title) || isset($uRel->detail))
                                            <div class="detail-wrap">
                                                @if(isset($uRel->title))
                                                    <h4>{{ $uRel->title }}</h4>
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


