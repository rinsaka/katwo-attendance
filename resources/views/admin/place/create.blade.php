@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    主な活動施設一覧（管理者モード）
  </div>
  <div class="card-body">

    <form method="post" action="{{ route('admin_place_store') }}" enctype='multipart/form-data'>
      {{ csrf_field() }}

      <!-- 活動施設名 -->
      <div class="mb-4">
        <label for="place" class="form-label fw-semibold">活動施設名</label>
        <input id="place" name="place" type="text"
          class="form-control"
          maxlength="100" required placeholder="活動施設名"
          value="{{ old('place') }}"
        />
        <div class="form-text">活動施設名を入力してください（100文字以内）。</div>
        @if ($errors->has('place'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('place') }}</div>
        @endif
      </div>

      <!-- デフォルト活動施設 -->
      <div class="mb-3">
        <div class="form-text">デフォルト活動施設として設定したい場合はOnにしてください。</div>
        <ul class="list-group">
          <li class="list-group-item">
            <div class="form-check form-switch ps-0">
              <label class="form-check-label me-5">デフォルト活動施設に設定する</label>
              <input class="form-check-input float-end" type="checkbox" role="switch" name="default_place" id="default_place">
            </div>
          </li>
        </ul>
      </div>

      <!-- 送信 -->
      <div class="d-grid d-lg-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          活動施設を登録する
        </button>
      </div>

    </form>

    <!-- テキストリンク（中央寄せ） -->
    <p class="text-center mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@place') }}">
        活動施設一覧（管理者モード）に戻る
      </a>
    </p>

  </div>
</div>
</main>
@include('layouts.admin-footer')
@endsection
