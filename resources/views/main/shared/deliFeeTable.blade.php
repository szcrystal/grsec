<?php
use App\Setting;
use App\Prefecture;
use App\DeliveryGroupRelation;
?>

@if($item->is_delifee_table)
    <div class="btn btn-custom mt-4 slideDeli">
        送料表を見る <i class="fal fa-angle-down"></i>
    </div>
    <?php
        $dgRels = DeliveryGroupRelation::where('dg_id', $item->dg_id)->get();
    ?>
    
    
    <div class="table-responsive table-deli text-small mt-2">
        <table class="table table-bordered bg-white">
            <thead class="bg-light">
                <tr>
                    <td class="text-center" colspan="2">地域</td>
                    <td class="text-center">送料</td>
                </tr>
            </thead>
            
            <tbody>
                @foreach($dgRels as $dgRel)
                    <tr>
                        <?php
                            $format = '<td class="bg-light" rowspan="%d">'. Prefecture::find($dgRel->pref_id)->rural . '</td>';
                        ?>
                            
                        @if($dgRel->pref_id == 1)
                            <?php printf($format, 1); ?>
                        
                        @elseif($dgRel->pref_id == 2)
                            <?php printf($format, 6); ?>
                        
                        @elseif($dgRel->pref_id == 8)
                            <?php printf($format, 7); ?>
                        
                        @elseif($dgRel->pref_id == 15)
                            <?php printf($format, 9); ?>
                        
                        @elseif($dgRel->pref_id == 24)
                            <?php printf($format, 7); ?>
                        
                        @elseif($dgRel->pref_id == 31)
                            <?php printf($format, 5); ?>
                        
                        @elseif($dgRel->pref_id == 36)
                            <?php printf($format, 4); ?>
                        
                        @elseif($dgRel->pref_id == 40)
                            <?php printf($format, 7); ?>
                        
                        @elseif($dgRel->pref_id == 47)
                            <?php printf($format, 1); ?>
                        @endif

                        
                        <td>{{ Prefecture::find($dgRel->pref_id)->name }}</td>
                        <td class="bg-light">
                            @if($dgRel->fee == 99999 || $dgRel->fee === null)
                                配送不可
                            @elseif(! $dgRel->fee)
                                <span class="text-danger">無料</span>
                            @else
                                {{ number_format($dgRel->fee) }} 円
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif


