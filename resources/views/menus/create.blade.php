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

<div class="card my-3 border-0 shadow-sm">
  <div class="card-header bg-primary text-white h5 mb-0">
    {{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }} @if (strlen($activity->note)) &nbsp; {{ $activity->note }}@endif の練習メニュー
  </div>
  <div class="card-body">
    <p class="mb-0 text-body-secondary">
      必要事項を入力し、ページ下部の「練習メニューを登録する」ボタンを押してください。
    </p>
  </div>
</div>

<!-- 入力フォームカード -->
<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="{{ route('menu_store') }}" enctype='multipart/form-data'>

      {{ csrf_field() }}
      <input type="hidden" name="aid" value="{{ $activity->id }}">
                      <input type="hidden" name="url" value="{{ url()->previous()}}">


      <!-- 投稿者名 -->
      <div class="mb-4">
        <label for="name" class="form-label fw-semibold">投稿者名</label>
        <input id="name" name="name" type="text"
          class="form-control"
          maxlength="30" required placeholder="投稿者名"
          value="{{ old('name') }}"
        />
        <div class="form-text">【必須】投稿者の名前を入れてください。</div>
        @if ($errors->has('name'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('name') }}</div>
        @endif
      </div>

      <!-- 練習メニュー -->
      <div class="mb-4">
        <label for="menu" class="form-label fw-semibold">投稿者名</label>
        <textarea name="menu" rows="10" class="form-control" placeholder="練習メニューやお知らせ事項を入力して下さい" required></textarea>
        <div class="form-text">【必須】練習メニューやお知らせ事項を入力して下さい。</div>
        @if ($errors->has('menu'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('menu') }}</div>
        @endif
      </div>


      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          練習メニューを登録する
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ url()->previous() }}">戻る</a>
      </p>

    </form>
  </div>
</div>

</main>
@include('layouts.footer')
@endsection
