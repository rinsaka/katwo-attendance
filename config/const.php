<?php
// 定数の定義
// 利用時は controller や view の中で次のように記述すれば良い
//       \Config::get('const.NEW_THRESHOLD')

return array(
  // 環境定数

  /*
    投稿に「New!」と表示する時間を分単位で指定する
  */
  'NEW_THRESHOLD' => 60 * 48,  // 48時間

  // メール文面作成に用いる情報
  'URL' => env('MAIL_URL', 'http://localhost/'),
  'UID' => env('MAIL_USER_ID', 'userid'),
  'UPW' => env('MAIL_USER_PASS', 'xyz1234'),

  // サンプルの情報
  'SAMPLE_URL' => env('SAMPLE_URL', null),
  'SAMPLE_MSG' => env('SAMPLE_MSG', null),
);
