@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main class="container-md">
@include('layouts.flash')


<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    メールのフッタ
  </div>
  <div class="card-body">
     <form>
        <p>
        <textarea name="menu" rows="15" class="form-control">{{ $mailinfo->mailinfo }}</textarea>
        </p>
    </form>
  </div>
  <div class="mb-3 px-2">
    <a href="{{ action('HomeController@index') }}">戻る</a>
  </div>
</div>

</main>

@endsection
