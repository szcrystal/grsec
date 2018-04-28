@extends('layouts.appDashBoard')

@section('content')

	<div class="clearfix">
    	<h3 class="page-header">Weekly Ranking</h3>
        <p class="text-success">{{ $span . ': '}}<span style="font-weight: bold;">{{ $count }}</span></p>
    </div>

    {{ $obj->links() }}

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-2">日付</th>
              <th class="col-md-1">記事ID</th>
              <th class="col-md-6">タイトル</th>
              <th class="col-md-3">View数</th>
            </tr>
          </thead>
          <tbody>

            @foreach($obj as $val)
                <tr>
                    <td>
                    	{{ $val['view_date'] }}
                    </td>

                    <td>
                        {{ $val['atcl_id'] }}
                    </td>
                    <td>
                        {{ $atcl->find($val['atcl_id'])->title }}
                    </td>

                    <td>
                        {{ $val['view_count'] }}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>

    </div>

    {{ $obj->links() }}

        
@endsection

