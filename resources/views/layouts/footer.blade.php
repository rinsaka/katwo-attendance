<footer class="text-bg-secondary p-4 rounded">
@if (\Config::get('const.SAMPLE_URL'))
<p>
  <a href="{{ \Config::get('const.SAMPLE_URL') }}" class="text-bg-secondary">
    {{ \Config::get('const.SAMPLE_MSG') }}
  </a>
</p>
@endif
<div class="text-end">
  <a href="{{ action('HomeController@mail_footer') }}" class="text-bg-secondary">
    メールフッタ
  </a>
</div>
<div>
  <a href="https://kat-wind.com/" class="text-bg-secondary">
    神戸学園都市吹奏楽団
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
