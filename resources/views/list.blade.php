@extends('layouts.app')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  すべての予定（一覧表示）
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                  <p>
                    @foreach ($month_acts as $act)
                      {{ $act }}<br>
                    @endforeach
                  </p>
                </div>
                <div  class="panel-footer" >
                  <p>
                    <a href="{{ action('HomeController@index') }}">戻る</a>
                  </p>
                  <p>&nbsp;</p>
                  {{-- フッターの表示 --}}
                  @include('layouts.footer')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
