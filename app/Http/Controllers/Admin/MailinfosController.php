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
    dd($request);
  }
}
