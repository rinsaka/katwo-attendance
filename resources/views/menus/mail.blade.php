@extends('layouts.app')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  {{ $menu->activity->act_at }} {{ $myController->get_youbi($menu->activity->act_at) }} @if (strlen($menu->activity->note)) <span class="note">&nbsp; {{ $menu->activity->note }}</span>@endif の案内メール文面
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form>
                      <p>
                        <label for="menu">メールの文面: </label>
                        <textarea name="menu" rows="50" class="form-control">{{ $mail }}</textarea>
                      </p>
                    </form>

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
