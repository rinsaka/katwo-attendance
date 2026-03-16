<footer class="text-bg-secondary p-4 rounded">

  <div class="">
    <a href="{{ action('Admin\HomeController@index') }}" class="link-body-emphasis">
      活動一覧
    </a>
  </div>

  <div class="">
    <a href="{{ action('Admin\HomeController@create') }}" class="text-bg-secondary">
      活動予定を新規登録
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\MailinfosController@edit') }}" class="text-bg-secondary">
      メールフッタを編集
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\HomeController@place') }}" class="text-bg-secondary">
      活動施設の一覧表示
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\HomeController@time') }}" class="text-bg-secondary">
      活動時間の一覧表示
    </a>
  </div>

  <div class="">
    This system is developed with <a href="https://laravel.com/" target="_blank" class="text-bg-secondary">Laravel</a>, <a href="https://lolipop.jp/" target="_blank" class="text-bg-secondary">LOLIPOP!</a> and <a href="https://github.com/rinsaka/katwo-attendance" target="_blank" class="text-bg-secondary">GitHub</a>.
  </div>

  <div class="">
    <a href="https://rinsaka.com/rinsaka/" class="text-bg-secondary">
      rinsaka.com
    </a>
  </div>

</footer>
