@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

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
  <div class="card-header bg-danger text-white h5 mb-0">
    削除の確認
  </div>
  <div class="card-body">
    <p class="mb-0 text-body-secondary">
      {{ $name }}&nbsp;さんの{{ $year }}年{{ $month }}月の予定（{{ count($attens) }}回）を削除してよろしいですか？ 本当に削除してよければ、下の確認用の文字列ボックスに「<b>katwo</b>」と入力してボタンをクリック（またはタップ）してください。
    </p>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">

    <form method="post" action="{{ route('destroy') }}" enctype='multipart/form-data'>
      {{ csrf_field() }}
      {{ method_field('delete') }}
      <input type="hidden" name="delete_token" value="katwo">
      <input type="hidden" name="name" value="{{ $name }}">
      <input type="hidden" name="year" value="{{ $year }}">
      <input type="hidden" name="month" value="{{ $month }}">
      <input type="hidden" name="aid" value="{{ $aid }}">
      @foreach ($attens as $atten)
        <input type="hidden" name="attens[]" value="{{ $atten }}">
      @endforeach

      <div class="mb-4">
        <label for="confirmation" class="form-label fw-semibold">確認用の文字列</label>
        <input id="confirmation" name="confirmation" type="text"
          class="form-control"
          required placeholder="katwo と入力してください"
          value=""
        />
        <div class="form-text">【必須】確認用文字列を入力してください。</div>
        @if ($errors->has('name'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('confirmation') }}</div>
        @endif
      </div>

      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-danger btn-sm">
          削除する
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('HomeController@show', [$year, $month]) }}">戻る</a>
      </p>
    </form>

  </div>
</div>
</main>
@include('layouts.footer')
@endsection
