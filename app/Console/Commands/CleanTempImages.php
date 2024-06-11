<?php

namespace App\Console\Commands;

use App\Models\TempImage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanTempImages extends Command
{

    protected $signature = 'app:clean-temp-images';

    protected $description = 'Clean old temporary images';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $expirationDate = Carbon::now()->subDays(7);
        $oldImages = TempImage::where('created_at', '<', $expirationDate)->get();

        foreach ($oldImages as $image) {
            File::delete(public_path('/temp/'.$image->name));
            File::delete(public_path('/temp/thumb/'.$image->name));
            $image->delete();
        }

        $this->info('Old temporary images cleaned successfully.');
    }


}
