<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Activity;

class MenusController extends Controller
{
  public function show($id)
  {
    $menu = Menu::where('id', '=', $id)->first();
    if (!$menu) {
      return redirect('/home')->with('status', '練習メニューが見つかりません');
    }
    // $url = url()->previous();
    return view('menus.edit')
            ->with('menu', $menu);
            // ->with('url', $url);
  }

  public function update(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:30',
      'menu' => 'required'
    ]);

    $menu = Menu::where('id', '=', $request->mid)->first();
    if (!$menu) {
      return redirect('/home')->with('status', '練習メニューが見つかりません');
    }
    $menu->name = $request->name;
    $menu->menu = $request->menu;
    $menu->save();

    return redirect($request->url)->with('status', '練習メニューを更新しました');
  }

  public function create(Request $request)
  {
    $activity = Activity::where('id', '=', $request->aid)->first();
    if (!$activity) {
      return redirect('/home')->with('status', 'アクティビティが見つかりません');
    }
    return view('menus.create')
            ->with('activity', $activity);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:30',
      'menu' => 'required'
    ]);
    $menu = new Menu();
    $menu->activity_id = $request->aid;
    $menu->name = $request->name;
    $menu->menu = $request->menu;
    $menu->save();

    return redirect($request->url)->with('status', '練習メニューを登録しました');
  }
}
