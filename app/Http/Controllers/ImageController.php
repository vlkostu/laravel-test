<?php

namespace App\Http\Controllers;

use App\Http\Requests\Images\StoreRequest;
use App\Models\Image;
use App\Models\User;
use App\Services\Images\ImageSave;
use App\Services\Images\ImageSendMail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    private $imageSave;
    private $imageSendMail;

    /**
     * ImageController constructor.
     * @param ImageSave $imageSave
     * @param ImageSendMail $imageSendMail
     */

    public function __construct(
        ImageSave $imageSave,
        ImageSendMail $imageSendMail
    )
    {
        parent::__construct();

        $this->imageSave = $imageSave;
        $this->imageSendMail = $imageSendMail;
    }

    /**
     * Upload image
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function upload(StoreRequest $request)
    {
        # Сохраняем изображение
        $this->imageSave->saveOriginalImage($request);
        # Сохраняем ресайзы
        $this->imageSave->saveImages(
            $this->imageSave->explodeWidths()
        );
        # Сохраняем теги
        $this->imageSave->saveTags(
            $this->imageSave->explodeTags()
        );
        # Отправялем письмо на мыло
        $this->imageSendMail->sendMail(
            $this->imageSave->imageQuery->imageResizes,
            auth()->id()
        );
        # Грузим рилейшены
        $this->imageSave->imageQuery->load([
            'imageResizes', 'imageTags'
        ]);

        return response()->json($this->imageSave->imageQuery);
    }

    /**
     * Get user images
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAll(Request $request)
    {
        return response()->json(
            auth()->user()->images()->first()->getImages($request)
        );
    }
}
