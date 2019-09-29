<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mailinfo;

class MailinfosController extends Controller
{
  public function edit()
  {
    $mailinfo = Mailinfo::where('key', '=', 'signiture')
                        ->first();
    if (!$mailinfo) {
      $mailinfo = new Mailinfo();
      $mailinfo->key = 'signiture';
      $mailinfo->mailinfo = 'メールフッタをここに';
      $mailinfo->save();
    }
    return view('admin.mailinfo')
            ->with('mailinfo', $mailinfo);
    // dd('edit', $mailinfo);
  }

  public function update(Request $request)
  {
    $this->validate($request, [
              'mailinfo' => 'required',  // 入力が必須
            ]);
    $mailinfo = Mailinfo::where('id', '=', $request->id)
                          ->where('key', '=', $request->key)
                          ->first();
    if (!$mailinfo) {
      return redirect('/admin/home')->with('status', '不正なパラメータです');
    }
    $mailinfo->mailinfo = $request->mailinfo;
    $mailinfo->save();
    return redirect('/admin/mailinfo')->with('status', "メールフッタを更新しました");
  }
}
