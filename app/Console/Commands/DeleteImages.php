<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteImages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        # Get images
        $images = Image::query()->where('delete_at', '<', now())
            ->orWhere('created_at', '>', now()->addMinutes(10))
            ->with('imagesResizes')
            ->get(['id', 'url', 'path']);

        # Delete images
        $images->each(function (Image $image) {
            # Delete resize images
            $image->imagesResizes->each(function ($imageResize) {
                File::delete($imageResize->path);
            });
            # Delete original image
            File::delete($image->path);
            # Delete db
            $image->delete();
        });

        return true;
    }
}
