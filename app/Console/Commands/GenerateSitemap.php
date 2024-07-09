<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Category;

class GenerateSitemap extends Command
{

    protected $signature = 'sitemap:generate';


    protected $description = 'Generate the sitemap.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/shop')->setPriority(0.9));

        // Adding categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap->add(Url::create("/shop/{$category->slug}")->setPriority(0.8));

            // Adding subcategories
            $subCategories = $category->subCategories; // Assuming you have a relation 'subCategories' in Category model
            foreach ($subCategories as $subCategory) {
                $sitemap->add(Url::create("/shop/{$category->slug}/{$subCategory->slug}")->setPriority(0.7));
            }
        }

        // Adding products with seo_index == 'index'
        $products = Product::where('seo_index', 'index')->get();
        foreach ($products as $product) {
            $sitemap->add(Url::create("/product/{$product->slug}")->setPriority(0.7));
        }

        // Adding static pages
        $staticPages = [
            'contact' => 'front.page.contact',
            'about' => 'front.page.about',
            'term-condition' => 'front.page.term-condition',
        ];
        foreach ($staticPages as $slug => $routeName) {
            $url = route($routeName);
            $sitemap->add(Url::create($url)->setPriority(0.6));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }

}
