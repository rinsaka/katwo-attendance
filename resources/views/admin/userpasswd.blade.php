@extends('layouts.admin-2026')

@section('content')

<main>
{{-- =========================
    Flash messages
========================= --}}
@foreach (['success' => 'success', 'error' => 'danger'] as $key => $bs)
  @if (session($key))
    <div class="alert alert-{{ $bs }} alert-dismissible fade show my-3" role="alert">
      {{ session($key) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
    </div>
  @endif
@endforeach

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    団員パスワードの変更
  </div>
  <div class="card-body">

    <form class="form-horizontal" method="POST" action="{{ route('admin.userpasswd') }}">
      {{ csrf_field() }}
      {{ method_field('patch') }}

      <input type="hidden" name="id" value="{{ $id }}">

      <h5 class="fw-bold">管理者の情報</h5>
      <!-- 管理者のパスワード -->
      <div class="mb-4 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="form-label fw-semibold">管理者パスワード</label>

        <input id="password" name="password" type="password"
        placeholder="管理者のパスワードを入力して下さい"
        class="form-control"
        required />
        @if ($errors->has('password'))
        <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
      </div>

      <hr class="border border-primary border-3 opacity-75">

      <h5 class="fw-bold">変更したい団員の情報</h5>

      <div class="mb-4 form-group{{ $errors->has('login_id') ? ' has-error' : '' }}">
        <label for="login_id" class="form-label fw-semibold">団員のログインID（変更されません）</label>

        <input id="login_id" name="login_id" type="text"
        placeholder="k.."
        class="form-control"
        required />
        @if ($errors->has('login_id'))
        <span class="help-block">
          <strong>{{ $errors->first('login_id') }}</strong>
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
          団員のパスワードを変更する
        </button>
      </div>

      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('Admin\HomeController@index') }}">戻る</a>
      </p>

    </form>
  </div>


</main>

@include('layouts.admin-footer')
@endsection
