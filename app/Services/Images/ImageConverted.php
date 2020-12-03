<?php

namespace App\Services\Images;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class ImageConverted
{
    private $image;
    private $fileName;

    /**
     * ImageConverted constructor.
     * @param string $imagePath
     */

    public function __construct(string $imagePath)
    {
        $this->image = Image::make($imagePath);
    }

    /**
     * Resize image
     *
     * @param $width
     * @param $ratio
     * @return $this
     */

    public function resize($width, $ratio)
    {
        # Resize image
        $this->image->resize($width, $width / $ratio, function ($constraint) {
            $constraint->upsize();
        });

        return $this;
    }

    /**
     * Add watermark
     *
     * @param $watermarkURL
     * @return $this
     */

    public function addWatermark($watermarkURL)
    {
        if (!$watermarkURL) return $this;

        $this->image->insert($this->watermarkResize($watermarkURL), 'top-right', 10, 10);

        return $this;
    }

    /**
     * Resize watermark
     *
     * @param $watermarkURL
     * @return \Intervention\Image\Image
     */

    public function watermarkResize($watermarkURL)
    {
        $size = ($this->image->width() / 100) * 20;

        if ($size > $this->image->width() or $size > $this->image->height()) $size = 20;

        return Image::make($watermarkURL)->resize($size, $size);
    }

    /**
     * Save image
     *
     * @return $this
     */

    public function save()
    {
        $this->image->save($this->path());

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */

    public function fileURL()
    {
        return Storage::url($this->fileName);
    }

    /**
     * Get path
     *
     * @return string
     */

    private function path()
    {
        return $this->saveFilePath() . $this->saveFileName();
    }

    /**
     * File base name
     *
     * @return string
     */

    private function saveFileName() {
        return $this->fileName = uniqid().$this->image->basename;
    }

    /**
     * File path
     *
     * @return string
     */

    private function saveFilePath()
    {
        return storage_path('app\public\\');
    }

    /**
     * Get path
     *
     * @return string
     */

    public function getPath()
    {
        return $this->saveFilePath() . $this->getFileName();
    }

    /**
     * Get save file name
     *
     * @return mixed
     */

    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Check resize
     *
     * @param $width
     * @return bool
     */

    public function resizeCheck($width)
    {
        if ($this->image->width() >= $width) return true;

        return false;
    }

    /**
     * Get width
     *
     * @return int
     */

    public function width()
    {
        return $this->image->width();
    }

    /**
     * Get height
     *
     * @return int
     */

    public function height()
    {
        return $this->image->height();
    }

    public function __destruct()
    {
        // TODO: destruct
    }
}
