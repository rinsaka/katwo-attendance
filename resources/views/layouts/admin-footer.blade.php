<footer class="text-bg-info p-3">

  <div class="">
    <a href="{{ action('Admin\HomeController@index') }}">
      活動一覧
    </a>
  </div>

  <div class="">
    <a href="{{ action('Admin\HomeController@create') }}">
      活動予定を新規登録
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\MailinfosController@edit') }}">
      メールフッタを編集
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\HomeController@place') }}">
      活動施設の一覧表示
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\HomeController@time') }}">
      活動時間の一覧表示
    </a>
  </div>

  <div class="">
    This system is developed with <a href="https://laravel.com/" target="_blank">Laravel</a>, <a href="https://lolipop.jp/" target="_blank">LOLIPOP!</a> and <a href="https://github.com/rinsaka/katwo-attendance" target="_blank">GitHub</a>.
  </div>

  <div class="">
    <a href="https://rinsaka.com/rinsaka/">
      rinsaka.com
    </a>
  </div>

</footer>
