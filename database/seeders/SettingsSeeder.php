<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    private $settings = [
        'store_logo'=>'',
        'store_logo_white'=>'',
        'favicon_icon'=>'',
        'store_name'=>'Shop name',
        'store_phone'=>'01xxxxxxxxx',
        'store_email'=>'info@sitename.com',
        'store_address'=>'123 Street, Old Trafford, NewYork, USA',
        'store_description'=>'If you are going to use of Lorem Ipsum need to be sure there is not anything hidden of text',
        'email_from_name'=>'Mahmoud',
        'email_from_address'=>'admin@example.com',
        'email_user_register'=>true,
        'email_user_register_admin'=>true,
        'email_user_new_order'=>true,
        'email_user_new_order_admin'=>true,
        'email_user_confirm_order'=>true,
        'email_user_order_delivering'=>true,
        'email_user_review_when_order_completed'=>true,
        'email_user_new_review'=>true,
        'email_user_confirm_review'=>true,
        'email_user_new_review_admin'=>true,
        'email_user_new_contact'=>true,
        'email_user_new_contact_admin'=>true,
        'facebook'=>'https://www.facebook.com',
        'x'=>'https://x.com',
        'youtube'=>'https://www.youtube.com',
        'instagram'=>'https://www.instagram.com',
        'recaptcha_site_key'=>'6Le9egQqAAAAADWMMl9UwfXL-fDJP4El9dIIlE26',
        'recaptcha_secret'=>'6Le9egQqAAAAAA4WOzC9_DpbPg7p6RHJe_9oCBPr',
        'facebook_client_id'=>'',
        'facebook_client_secret'=>'',
        'facebook_login_status'=>true,
        'facebook_redirect'=>true,
        'google_client_id'=>'',
        'google_client_secret'=>'',
        'google_login_status'=>true,
    ];
    public function run(): void
    {
        DB::table('settings')->delete();
        foreach ($this->settings as $key =>$value) {
            Settings::set($key,$value);
        }
    }
}
