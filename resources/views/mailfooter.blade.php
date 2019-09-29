@extends('layouts.app')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">メールフッタ</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form>
                      <p>
                        <label for="menu">メールのフッタ: </label>
                        <textarea name="menu" rows="15" class="form-control">{{ $mailinfo->mailinfo }}</textarea>
                      </p>
                    </form>



                </div>
                <div  class="panel-footer" >
                  <p>
                    <a href="{{ action('HomeController@index') }}">戻る</a>
                  </p>
                  {{-- フッターの表示 --}}
                  @include('layouts.footer')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
