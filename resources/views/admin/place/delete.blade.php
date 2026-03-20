@extends('layouts.admin-2026')

@section('content')
<main class="container-md">
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    活動施設の削除（管理者モード）
  </div>
  <div class="card-body">
    <div class="mb-4">
      次の情報を削除しますか？この操作は元に戻せません．
    </div>

    <form method="post" action="{{ action('Admin\HomeController@place_destroy', $place->id) }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
      <p>
        施設名：{{ $place->place }}<br>
        登録日時：{{ $place->created_at }}<br>
        最終更新：{{ $place->updated_at }}<br>
        登録済み活動回数：{{ $cnt }}
      </p>


      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-danger btn-lg">
          活動施設情報を削除する
        </button>
      </div>

      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('Admin\HomeController@index') }}">活動予定一覧（管理者モード）に戻る</a>
      </p>



    </form>


  </div>
</div>

</main>

@endsection
