@extends('layouts.admin-2026')

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
  <div class="card-header h5 mb-0">
    活動施設の編集（管理者モード）
  </div>
  <div class="card-body">

    <div class="mb-4">
      ここで施設名を変更すると「{{ $place->place }}」で登録されている全ての活動予定の施設名が更新されます．
    </div>

    <form method="post" action="{{ route('admin_place_update') }}" enctype='multipart/form-data'>
      {{ csrf_field() }}
      {{ method_field('patch') }}
      <input type="hidden" name="pid" value="{{ $place->id }}">

      <!-- 活動施設名 -->
      <div class="mb-4">
        <label for="place" class="form-label fw-semibold">活動施設名</label>
        <input id="place" name="place" type="text"
          class="form-control"
          maxlength="100" required placeholder="活動施設名"
          value=
          @if ($errors->any())
            "{{ old("place") }}"
          @else
            "{{ $place->place }}"
          @endif
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
              <label class="form-check-label me-5">
                @if ($place->default_place)
                  デフォルト活動施設に設定されています
                @else
                  デフォルト活動施設に設定する
                @endif
              </label>
              <input class="form-check-input float-end" type="checkbox" role="switch" name="default_place" id="default_place"
              @if ($place->default_place)
                checked disabled
              @endif
              >
            </div>
          </li>
        </ul>
      </div>

      <div class="mb-4 text-secondary" >
        登録日時：{{ $place->created_at }}<br>
        最終更新：{{ $place->updated_at }}
      </div>


      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          活動施設名を変更する
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('Admin\HomeController@index') }}">活動予定一覧（管理者モード）に戻る</a>
      </p>

      <p class='mt-2 mb-0'>
        <a href="{{ action('Admin\HomeController@place_delete', $place->id) }}">
          活動施設情報を削除する
        </a>
      </p>

    </form>


  </div>
</div>

</main>

@include('layouts.admin-footer')
@endsection
