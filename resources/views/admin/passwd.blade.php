@extends('layouts.admin-2026')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    管理者パスワードの変更
  </div>
  <div class="card-body">

    <form class="form-horizontal" method="POST" action="{{ route('admin.passwd') }}">
      {{ csrf_field() }}
      {{ method_field('patch') }}

      <input type="hidden" name="id" value="{{ $id }}">

      <!-- 現在のパスワード -->
      <div class="mb-4 form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
        <label for="current_password" class="form-label fw-semibold">現在のパスワード</label>

        <input id="current_password" name="current_password" type="password"
        class="form-control"
        required />
        @if ($errors->has('current_password'))
        <span class="help-block">
          <strong>{{ $errors->first('current_password') }}</strong>
        </span>
        @endif
      </div>


      <!-- 新しいパスワード -->
      <div class="mb-4 form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
        <label for="new_password" class="form-label fw-semibold">新しいパスワード</label>

        <input id="new_password" name="new_password" type="password"
        class="form-control"
        required />
        @if ($errors->has('new_password'))
        <span class="help-block">
          <strong>{{ $errors->first('new_password') }}</strong>
        </span>
        @endif
      </div>

      <!-- 新しいパスワード（確認用） -->
      <div class="mb-4 form-group{{ $errors->has('new_password_confirm') ? ' has-error' : '' }}">
        <label for="new_password_confirm" class="form-label fw-semibold">新しいパスワード（確認用として同じものを入力して下さい）</label>

        <input id="new_password_confirm" name="new_password_confirm" type="password"
        class="form-control"
        required />
        @if ($errors->has('new_password_confirm'))
        <span class="help-block">
          <strong>{{ $errors->first('new_password_confirm') }}</strong>
        </span>
        @endif
      </div>

      <!-- 送信 -->
      <div class="d-grid d-lg-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          管理者パスワードを変更する
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
