@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">メールフッタの編集（管理者モード）</div>

                <div class="panel-body">
                    {{-- フラッシュメッセージの表示 --}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                      <form method="post" action="{{ route('admin.mailinfo') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                        <input type="hidden" name="id" value="{{ $mailinfo->id }}">
                        <input type="hidden" name="key" value="{{ $mailinfo->key }}">

                        <p>
                          <textarea name="mailinfo" placeholder="メールに付けるフッタをここに入力して下さい" rows="20" class="form-control">{{ $mailinfo->mailinfo }}</textarea>
                          @if ($errors->has('mailinfo'))
                            <span class="error">{{ $errors->first('mailinfo') }}</span>
                          @endif
                        </p>

                        <hr>
                        <p>
                          <input type="submit" value="　　　活動予定を変更　　　" class="form-control submit_button">
                        </p>
                      </form>
                    </div>


                </div>

                <div  class="panel-footer">
                  <p><a href="{{ action('Admin\HomeController@index') }}">
                    戻る
                  </a></p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
