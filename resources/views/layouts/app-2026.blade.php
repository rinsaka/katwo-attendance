<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"  data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- 初期テーマ適用（最速反映のため head 内で実行） -->
    <script>
      (function () {
        const STORAGE_KEY = "bs-theme";
        const stored = localStorage.getItem(STORAGE_KEY);
        const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        const initialTheme = stored || (prefersDark ? "dark" : "light");
        document.documentElement.setAttribute("data-bs-theme", initialTheme);
      })();
    </script>
</head>
<body>
<div class="container-md">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{  url('/') }}">Kat-WO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      @if (Auth::guest())
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
      </ul>
      @else
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <!-- テーマ切替ドロップダウン（右寄せの左側） -->
        <li class="nav-item dropdown me-lg-2">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            id="themeDropdown"
          >
            テーマ
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-theme-value="light">
                ☀ Light
                <span class="ms-auto checkmark" aria-hidden="true" hidden>✔</span>
              </button>
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-theme-value="dark">
                🌙 Dark
                <span class="ms-auto checkmark" aria-hidden="true" hidden>✔</span>
              </button>
            </li>
            <li><hr class="dropdown-divider" /></li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-theme-value="auto">
                🖥 Auto（OSに追従）
                <span class="ms-auto checkmark" aria-hidden="true" hidden>✔</span>
              </button>
            </li>
          </ul>
        </li>

        <!-- ユーザードロップダウン（右端） -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                  Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      </ul>
      @endif
    </div>
  </div>
</nav>

@yield('content')


</div>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<!-- テーマ切替ロジック -->
<script>
  (function () {
    const STORAGE_KEY = "bs-theme";
    const media = window.matchMedia("(prefers-color-scheme: dark)");
    const dropdownItems = document.querySelectorAll('[data-theme-value]');
    const themeDropdown = document.getElementById('themeDropdown');

    function applyTheme(theme) {
      document.documentElement.setAttribute("data-bs-theme", theme);
      updateDropdownUI(theme);
    }

    function setThemeAndPersist(value) {
      if (value === "auto") {
        // Auto: 保存を消して OS 設定に追従
        localStorage.removeItem(STORAGE_KEY);
        applyTheme(media.matches ? "dark" : "light");
      } else {
        // Light/Dark: 明示設定して保存
        localStorage.setItem(STORAGE_KEY, value);
        applyTheme(value);
      }
    }

    function updateDropdownUI(theme) {
      // チェックマーク＆aria-current更新
      dropdownItems.forEach((el) => {
        const val = el.getAttribute("data-theme-value");
        const selected =
          (val === "auto" && !localStorage.getItem(STORAGE_KEY)) ||
          (val === theme && !!localStorage.getItem(STORAGE_KEY));

        el.setAttribute("aria-current", selected ? "true" : "false");
        const mark = el.querySelector(".checkmark");
        if (mark) mark.hidden = !selected;
      });

      // トリガーのテキストも更新
      const hasStored = !!localStorage.getItem(STORAGE_KEY);
      const label = hasStored ? (theme === "dark" ? "Dark" : "Light") : "Auto";
      if (themeDropdown) themeDropdown.textContent = `テーマ（${label}）`;
    }

    // 初期描画
    (function init() {
      const stored = localStorage.getItem(STORAGE_KEY);
      const theme = stored || (media.matches ? "dark" : "light");
      applyTheme(theme);
    })();

    // クリックイベント
    dropdownItems.forEach((el) => {
      el.addEventListener("click", () => {
        const value = el.getAttribute("data-theme-value");
        setThemeAndPersist(value);
      });
    });

    // OS設定の変更に追従（Auto のときのみ）
    media.addEventListener?.("change", (e) => {
      if (!localStorage.getItem(STORAGE_KEY)) {
        applyTheme(e.matches ? "dark" : "light");
      }
    });
  })();
</script>
</body>
</html>
