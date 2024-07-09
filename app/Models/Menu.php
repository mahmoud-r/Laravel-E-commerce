<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['title','location','content'];


    public function getMenuItems()
    {
        if ($this->content != '') {
            return $this->processMenuContent(json_decode($this->content));
        } else {
            return MenuItem::where('menu_id', $this->id)->get();
        }
    }

    private function processMenuContent($menuItems)
    {
        foreach ($menuItems as $menuItem) {
            $this->fillMenuItemDetails($menuItem);

            if (!empty($menuItem->children)) {
                foreach ($menuItem->children as $child) {
                    $this->fillMenuItemDetails($child);
                    if (!empty($child->children)) {
                        foreach ($child->children as $child) {
                            $this->fillMenuItemDetails($child);
                        }
                    }
                }
            }
        }
        return $menuItems;
    }

    private function fillMenuItemDetails(&$menuItem)
    {
        $item = MenuItem::find($menuItem->id);
        $menuItem->title = $item->title;
        $menuItem->name = $item->name;
        $menuItem->slug = $item->slug;
        $menuItem->target = $item->target;
        $menuItem->type = $item->type;
    }


}
