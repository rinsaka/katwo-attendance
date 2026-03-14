@extends('layouts.admin-2026')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    メールフッタの編集（管理者モード）
  </div>
  <div class="card-body">

    <form method="post" action="{{ route('admin.mailinfo') }}" enctype='multipart/form-data'>
      {{ csrf_field() }}

      <input type="hidden" name="id" value="{{ $mailinfo->id }}">
      <input type="hidden" name="key" value="{{ $mailinfo->key }}">

      <p>
        <textarea name="mailinfo" placeholder="メールに付けるフッタをここに入力して下さい" rows="8" class="form-control">{{ $mailinfo->mailinfo }}</textarea>
        @if ($errors->has('mailinfo'))
          <span class="error">{{ $errors->first('mailinfo') }}</span>
        @endif
      </p>

      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          メールフッタを更新
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('Admin\HomeController@index') }}">戻る</a>
      </p>
    </form>


  </div>
</div>

</main>

@include('layouts.admin-footer')
@endsection
