<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\storePagesRequest;
use App\Http\Traits\ImageTrait;
use App\Models\Category;
use App\Models\Page;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;

class PagesController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:pages-home-page|pages-home-banners|pages-contact-page|pages-about-page|pages-term-condition-page', ['only' => ['index','store'] ]);
        $this->middleware('permission:pages-home-page', ['only' => ['home','getSources']]);
        $this->middleware('permission:pages-home-banners', ['only' => ['HomeBanners','HomeBannersStore']]);
        $this->middleware('permission:pages-contact-page', ['only' => ['HomeBanners','contactPage']]);
        $this->middleware('permission:pages-about-page', ['only' => ['ImgAboutStore','aboutPage','BoxIconStore']]);
        $this->middleware('permission:pages-term-condition-page', ['only' => ['termConditionPage']]);


    }

    function index(){
        return view('admin.pages.index');
    }

    // store all pages
    function store(storePagesRequest $request){

        if ($request->has('contact.slug')) {
            $slug = Str::slug($request->input('contact.slug'));
            $contactData = $request->input('contact');
            $contactData['slug'] = $slug;
            $request->merge(['contact' => $contactData]);
        }

        foreach ($request->input() as $key=>$value){
            Page::setContent($key, $value);
        }
        return response()->json([
            'status'=>true,
            'msg'=>'Page Updated Successfully'
        ]);
    }

    //edit Home page sections
    function home(){
        $homeSections = Page::getContent('homeSections');
        return view('admin.pages.home',compact('homeSections'));
    }

    //get source sections for values
    public function getSources($type)
    {
        if ($type == 'category') {
            $sources = Category::all(['id', 'name']);
        } elseif ($type == 'collection') {
            $sources = ProductCollection::all(['id', 'name']);
        } else {
            $sources = [];
        }

        return response()->json($sources);
    }

    //edit Home Banners  sections
    function HomeBanners(){
        $homeBanners = Page::getContent('homeBanners');
        return view('admin.pages.banners',compact('homeBanners'));
    }


    //just Save img Banners
    function HomeBannersStore(Request $request){

        $Banners = Page::getContent('homeBanners');
        $newBanners = $request->input()['homeBanners'];

        foreach ($newBanners as $key =>$Banner){
            if (!empty($newBanners[$key]['img'])){

                File::delete(public_path('/uploads/home_banners/images/'.$Banners[$key]['img']));

                $newImageName =$this->saveImage($Banner['img'],$key,'home_banners');
                $Banners[$key]['img'] = $newImageName;
            }
        }
        Page::setContent('homeBanners', $Banners);

        return response()->json([
            'status'=>true,
            'msg'=>'Banner Updated Successfully',
            'img'=>$newImageName
        ]);
    }


    //contact Page
    function contactPage(){
        $contact = Page::getContent('contact');
        return view('admin.pages.contact',compact('contact'));
    }


    //About Page
    function aboutPage(){
        $about = Page::getContent('about');
        return view('admin.pages.about',compact('about'));
    }
    //just Save img
    function ImgAboutStore(Request $request){

        $about = Page::getContent('about');
        $newImg = $request->input()['about'];

        if (!empty($newImg['section1']['img'])){

            File::delete(public_path('/uploads/pages/images/'.$about['section1']['img']));

            $newImageName =$this->saveImage($newImg['section1']['img'],'about-section1','pages');

            $about['section1']['img'] = $newImageName;
        }
        Page::setContent('about', $about);

        return response()->json([
            'status'=>true,
            'msg'=>'Image Updated Successfully',
            'img'=>$newImageName
        ]);
    }

    //just Save Box icon
    function BoxIconStore(Request $request){


        $aboutPage = Page::getContent('about');
        $newicon = $request->input()['about']['section2']['subsections'];


        foreach ($newicon as $key =>$icon){

            if (!empty($icon['icon'])){

                File::delete(public_path('/uploads/pages/images/'.$aboutPage['section2']['subsections'][$key]['icon']));
                $newImageName =$this->saveImage($icon['icon'],$key,'pages',45);

                $aboutPage['section2']['subsections'][$key]['icon'] = $newImageName;


            }
        }
        Page::setContent('about', $aboutPage);

        return response()->json([
            'status'=>true,
            'msg'=>'Banner Updated Successfully',
            'img'=>$newImageName
        ]);
    }




    //term-condition Page
    function termConditionPage(){
        $page = Page::getContent('term-condition');
        return view('admin.pages.term-condition',compact('page'));
    }


}
