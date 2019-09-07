@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  団員パスワードの変更
                </div>

                <div class="panel-body">
                    {{-- フラッシュメッセージの表示 --}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('admin.userpasswd') }}">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}



                        <input type="hidden" name="id" value="{{ $id }}">

                        <h4>管理者の情報</h4>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">管理者パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="管理者のパスワードを入力して下さい" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>
                        <h4>変更したい団員の情報</h4>
                          <div class="form-group row">
                              <label for="login_id" class="col-md-4 col-form-label text-md-right">団員のログインID（変更されません）</label>

                              <div class="col-md-6">
                                  <input id="login_id" type="text" class="form-control" name="login_id" value="{{ old('login_id') }}" placeholder="団員のログインIDを入れて下さい（これは変更されません）" required>

                                  @if ($errors->has('current_password'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('current_password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="new_password" class="col-md-4 col-form-label text-md-right">新しいパスワード'</label>

                              <div class="col-md-6">
                                  <input id="new_password" type="password" class="form-control" name="new_password" required>

                                  @if ($errors->has('new_password'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('new_password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="new_password-confirm" class="col-md-4 col-form-label text-md-right">新しいパスワード（確認用として同じものを入力して下さい）</label>

                              <div class="col-md-6">
                                  <input id="new_password-confirm" type="password" class="form-control" name="new_password_confirmation" required>
                              </div>
                          </div>


                      <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary btn-block">
                                団員のパスワードを変更する
                              </button>
                          </div>
                      </div>
                    </form>

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
