<?php


namespace App\Services\Images;


use App\Models\ImagesResize;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Mail;

class ImageSendMail
{
    /**
     * Send mail
     *
     * @param $images
     * @param $user
     * @return bool
     */

    public function sendMail($images, $id)
    {
        $user = User::findOrFail($id);

        Mail::send('mail.images', [
            'user' => $user,
            'images' => $images
        ], function ($message) use ($user) {
            $message->to('vlad95715@gmail.com')->subject('Фото.');
        });

        return true;
    }
}
