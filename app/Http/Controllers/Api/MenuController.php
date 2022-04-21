<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
  public function index()
  {
    $menu = Menu::all();
    return $menu;
  }

  public function store(Request $request)
  {
    $menu = new Menu();
    $menu->name = $request->name;
    $menu->description = $request->description;
    $menu->price = $request->price;
    $menu->save();
  }

  public function show($id)
  {
    $menu = Menu::find($id);
    return $menu;
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name',
      'description',
      'price'
    ]);
    $menu = Menu::find($id);
    $menu->name = $request->get('name');
    $menu->description = $request->get('description');
    $menu->price = $request->get('price');
    $menu->save();
    return $menu;
  }

  public function destroy($id)
  {
    $menu = Menu::destroy($id);
    return $menu;
  }
}
