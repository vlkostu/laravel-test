<?php


namespace App\Services\Images;

use App\Models\ImagesResize;
use App\Models\ImagesTag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class ImageSave
{

    public $imageQuery;
    public $request;
    public $file;

    /**
     * Save original image
     *
     * @param Request $request
     */

    public function saveOriginalImage(Request $request)
    {
        $this->request = $request;
        # Save image
        $this->file = $this->saveFile($this->request->file('image'));

        $this->imageQuery = auth()->user()->images()->create([
            'url' => Storage::url($this->file),
            'delete_at' => $this->request->get('delete_at', now()->addMinutes(10)),
            'path' => $this->getPath()
        ]);
    }

    /**
     * Resize images
     *
     * @return \Illuminate\Support\Collection
     */

    public function explodeWidths()
    {
        # We get a list of widths.
        $widths = collect($this->request->get('widths'));
        # We iterate over all values and resize.
        $images = $widths->map(function ($width) {
            # Check
            if (!$image = $this->resizeImage($width)) {
                return null;
            }
            # Create new image.
            return new ImagesResize([
                'url' => $image->fileURL(),
                'width' => $image->width(),
                'path' => $image->getPath()
            ]);
        });

        return $images;
    }

    /**
     * Resize image
     *
     * @param $width
     * @return string
     */

    public function resizeImage($width)
    {
        $image = new ImageConverted($this->getPath());

        if (!$image->resizeCheck($width)) return false;

        $image->resize($width, $this->request->get('ratio', 1.0))
            ->addWatermark($this->request->get('watermark_url', false))
            ->save();

        return $image;
    }

    /**
     * Save resize images
     *
     * @param $images
     * @return mixed
     */

    public function saveImages(Collection $images)
    {
        return $this->imageQuery->imageResizes()->saveMany(
            $this->filter($images)
        );
    }

    /**
     * Explode tags
     *
     * @return bool|Collection
     */

    public function explodeTags()
    {
        if (!$this->request->filled('tags')) return false;
        # Get tags
        $tags = Str::of($this->request->get('tags'))->explode(',');
        # Through
        return $tags->map(function ($tag) {
            return new ImagesTag([
                'name' => $this->replaceTag($tag)
            ]);
        });
    }

    /**
     * Replace tag
     *
     * @param $tag
     * @return Stringable
     */

    public function replaceTag($tag)
    {
        return Str::of($tag)->replace(" ", '');
    }

    /**
     * Save tags
     *
     * @param $tags
     * @return mixed
     */

    public function saveTags($tags)
    {
        if (!$tags) return false;
        return $this->imageQuery->imageTags()->saveMany(
            $this->filter($tags)
        );
    }

    /**
     * Filter collection
     *
     * @param Collection $collection
     * @return Collection
     */

    private function filter(Collection $collection)
    {
        return $collection->filter(function ($value) {
            return $value != null;
        });
    }

    /**
     * Save file
     *
     * @param $file
     * @return mixed
     */

    private function saveFile(UploadedFile $file)
    {
        # Generate name
        $fileName = uniqid('originalImage-').$file->getClientOriginalName();
        # Save
        Storage::disk('public')->put($fileName, file_get_contents($this->request->file('image')));

        return $fileName;
    }

    /**
     * Get path original file
     *
     * @return mixed
     */

    public function getPath()
    {
        return Storage::disk('public')->path($this->file);
    }
}
