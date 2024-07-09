<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete', ['only' => ['index'] ]);
        $this->middleware('permission:menu-create', ['only' => ['store','create']]);
        $this->middleware('permission:menu-edit', ['only' => ['update','addCatToMenu','addPage','updateMenu','updateMenuItem','deleteMenuItem']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);

    }
    public function index(Request $request)
    {
        $menus = Menu::all();

        if ($menus->isEmpty()) {
            return redirect()->route('menus.create');
        }
        $categories = Category::all();

        $desiredMenu = $request->get('id') ? Menu::find($request->get('id')) : Menu::latest()->first();
        if ($desiredMenu) {
            $menuitems = $desiredMenu->getMenuItems();
        } else {
            $menuitems = [];
        }
        return view('admin.menus.index', compact('menus', 'categories', 'desiredMenu', 'menuitems'));
    }


    public function create(){
        $menus = menu::all();
        $categories = Category::all();
        return view('admin.menus.create', compact( 'categories','menus'));

    }

    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'title' => 'required'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if(menu::create($data)){
            $newdata = menu::orderby('id','DESC')->first();
            session()->flash('success','Menu saved successfully !');
            return redirect()->route('menus.index',$newdata->id);
        }else{
            return redirect()->back()->with('error','Failed to save menu !');
        }
    }


    public function addCatToMenu(Request $request)
    {
        $menuId = $request->input('menuid');
        $ids = $request->input('ids');
        $menu = Menu::findOrFail($menuId);

        $categories = Category::whereIn('id', $ids)->get();

        $newItems = [];

        foreach ($categories as $category) {
            $menuItemData = [
                'title' => $category->name,
                'slug' => route('front.shop',$category->name),
                'type' => 'category',
                'menu_id' => $menuId,
                'name' => null,
                'target' => null,
                'children' => []
            ];
            $newItem = MenuItem::create($menuItemData);
            $menuItemData['id'] = $newItem->id;
            $newItems[] = $menuItemData;
        }

        if (empty($menu->content)) {
            $menu->content = json_encode($newItems);
        } else {
            $oldData = json_decode($menu->content, true);
            $oldData = array_merge($oldData, $newItems);
            $menu->content = json_encode($oldData);
        }

        $menu->save();

        return response()->json(['status' => 'success']);
    }

    public function addCustomLink(Request $request)
    {
        $menuId = $request->input('menuid');
        $menu = Menu::findOrFail($menuId);
        $menuItemData = [
            'title' => $request->input('link'),
            'slug' => $request->input('url'),
            'type' => 'custom',
            'menu_id' => $menuId,
            'name' => null,
            'target' => null,
            'children' => []
        ];

        $newItem = MenuItem::create($menuItemData);

        if (empty($menu->content)) {
            $menuItemData['id'] = $newItem->id;
            $menu->content = json_encode([$menuItemData]);

        } else {
            $oldData = json_decode($menu->content, true);
            $menuItemData['id'] = $newItem->id;
            $oldData[] = $menuItemData;
            $menu->content = json_encode($oldData);
        }

        $menu->save();

        return response()->json(['status' => 'success']);
    }
    public function addPage(Request $request)
    {

        $menuId = $request->input('menuid');
        $menu = Menu::findOrFail($menuId);
        $newItems = [];

        foreach ($request->pages as $page) {
            $menuItemData = [
                'title' => $page['title'],
                'slug' => $page['url'],
                'type' => 'page',
                'menu_id' => $menuId,
                'name' => null,
                'target' => null,
                'children' => []
            ];
            $newItem = MenuItem::create($menuItemData);
            $menuItemData['id'] = $newItem->id;
            $newItems[] = $menuItemData;
        }

        if (empty($menu->content)) {
            $menu->content = json_encode($newItems);
        } else {
            $oldData = json_decode($menu->content, true);
            $oldData = array_merge($oldData, $newItems);
            $menu->content = json_encode($oldData);
        }

        $menu->save();

        return response()->json(['status' => 'success']);
    }

    public function updateMenu(Request $request)
    {
        $menuId = $request->input('menuid');
        $validator = validator::make($request->all(),[
            'location' => 'unique:menus,location,' . $menuId,
            'title' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>'false',
                'error'=>$validator->errors()
            ]);
        }
        $menu = Menu::findOrFail($menuId);
        $menu->update([
            'location' => $request->input('location'),
            'title' => $request->input('title'),
            'content' => json_encode($request->input('data'))
        ]);

        session()->flash('success','Menu Updated Successfully');
        return response()->json(['status' => 'true']);
    }

    public function updateMenuItem(Request $request ,$id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($request->all());

        return redirect()->back()->with('success', 'Menu item updated successfully');
    }

    public function deleteMenuItem($id, $key, $in = '',$in2 = '')
    {
        $menuItem = MenuItem::findOrFail($id);
        $menu = Menu::findOrFail($menuItem->menu_id);

        if (!empty($menu->content)) {
            $data = json_decode($menu->content, true);

            if ($in === '') {
                unset($data[$key]);

            } elseif ($in2 === '') {
                unset($data[$in]['children'][$key]);
            }else{
                unset($data[$in]['children'][$in2]['children'][$key]);
            }

            $menu->content = json_encode(array_values($data));
            $menu->save();
        }

        $menuItem->delete();

        return redirect()->back()->with('success', 'Menu item deleted successfully');
    }

    public function destroy($id)
    {
        MenuItem::where('menu_id', $id)->delete();
        Menu::findOrFail($id)->delete();

        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully');
    }








}
