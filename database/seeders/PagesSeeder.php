<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{

    private $pages = [
        'homeSections'=>[
            'section1'=> [
                'title' => 'Top Categories',
                'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.'
            ],
            'section2'=> [
                'title' => 'Deal Of The Day',
            ],
            'section3'=>[
                'title' => 'Exclusive Products',
                'subsections' => [
                    [
                        'title' => 'New Arrival',
                        'source_type' => 'collection',
                        'source_id' => ''
                    ],
                    [
                        'title' => 'Best Sellers',
                        'source_type' => 'collection',
                        'source_id' => ''
                    ],
                    [
                        'title' => 'Featured',
                        'source_type' => 'collection',
                        'source_id' => ''
                    ],
                    [
                        'title' => 'Special Offer',
                        'source_type' => 'collection',
                        'source_id' => ''
                    ],
                ]
            ],
            'section4'=> [
                'title' => 'test',
                'subsections' => [
                    [
                    'source_type' => 'category',
                    'source_id' => ''
                    ]
                ]
            ],
            'section5'=>[
                'title' => 'Exclusive Products',
                'subsections' => [
                    [
                        'title' => 'Featured Products',
                        'source_type' => 'collection',
                        'source_id' => ''
                    ],
                    [
                        'title' => 'Top Rated Products',
                        'source_type' => 'top_rated',
                        'source_id' => ''
                    ],
                    [
                        'title' => 'On Sale Products',
                        'source_type' => 'collection',
                        'source_id' => ''
                    ],
                ]
            ],

        ],
        'homeBanners'=>[
            'banner1'=>[
                'link'=>'',
                'status'=>true,
                'img'=>'',
            ],
            'banner2'=>[
                'link'=>'',
                'status'=>true,
                'img'=>'',
            ],
            'banner3'=>[
                'link'=>'',
                'status'=>true,
                'img'=>'',
            ],

        ],
        'contact'=>[
            'title'=>'Contact Us',
            'slug'=>'contact-us',
            'address'=>'123 Street, Old Trafford, London, UK',
            'email'=>'info@yourmail.com',
            'phone'=>'+ 457 789 789 65',
            'form_title'=>'Get In Touch',
            'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.',
            'map_latitude'=>'40.680',
            'map_longitude'=>'-73.945',
            'zoom'=>'12',
        ],
        'about'=>[
            'title'=>'About Us',
            'slug'=>'about-us',
            'section1'=>[
                'img'=>'',
                'title'=>'Who We Are',
                'description'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. consequuntur quibusdam enim expedita sed nesciunt incidunt accusamus adipisci officia libero laboriosam!',
            ],
            'section2'=>[
                'title'=>'Why Choose Us?',
                'description'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. consequuntur quibusdam enim expedita sed nesciunt incidunt accusamus adipisci officia libero laboriosam!',
                'subsections'=>[
                    'box1'=>[
                        'title'=>'Creative Design',
                        'description'=>'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form',
                        'icon'=>''
                    ],
                    'box2'=>[
                        'title'=>'Flexible Layouts',
                        'description'=>'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form',
                        'icon'=>''
                    ],
                    'box3'=>[
                        'title'=>'Email Marketing',
                        'description'=>'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form',
                        'icon'=>''
                    ],
                ],

            ],

        ],
        'term-condition'=>[
            'title'=>'Terms And Conditions',
            'slug'=>'term-condition',
            'content'=>''

        ],
    ];

    public function run(): void
    {
        DB::table('pages')->delete();
        foreach ($this->pages as $key =>$value) {
            Page::setContent($key, $value);
        }



    }
}
