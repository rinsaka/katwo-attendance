<footer>
@if (\Config::get('const.SAMPLE_URL'))
<p>
  <a href="{{ \Config::get('const.SAMPLE_URL') }}">
    {{ \Config::get('const.SAMPLE_MSG') }}
  </a>
</p>
@endif
<p class="pull-right">
  <a href="{{ action('HomeController@mail_footer') }}">
    メールフッタ
  </a>
</p>
<p>
  <a href="https://kat-wind.com/">
    神戸学園都市吹奏楽団
  </a>
</p>
<p>
  This system is developed with <a href="https://laravel.com/" target="_blank">Laravel</a>, <a href="https://lolipop.jp/" target="_blank">LOLIPOP!</a> and <a href="https://github.com/rinsaka/katwo-attendance" target="_blank">GitHub</a>.
</p>
<p>
  <a href="https://rinsaka.com/rinsaka/">
    rinsaka.com
  </a>
</p>
</footer>
