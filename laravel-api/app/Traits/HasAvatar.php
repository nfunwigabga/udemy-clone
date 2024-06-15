<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAvatar
{
    /**
     * Update the user's profile photo.
     *
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->avatar_url, function ($previous) use ($photo) {
            $this->forceFill([
                'avatar_url' => $photo->storePublicly(
                    $this->id, ['disk' => $this->avatarDisk()]
                ),
                'avatar_disk' => $this->avatarDisk(),
            ])->save();

            if ($previous && Storage::disk($this->avatarDisk())->exists($this->avatar_url)) {
                Storage::disk($this->avatarDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        if (is_null($this->avatar_url)) {
            return;
        }

        Storage::disk($this->avatarDisk())->delete($this->avatar_url);

        $this->forceFill([
            'avatar_url' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->avatar_url
            ? Storage::disk($this->avatarDisk())->url($this->avatar_url)
            : $this->defaultAvatarUrl();
    }

    public function getAvatarAttribute()
    {
        return $this->profile_photo_url;
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultAvatarUrl()
    {
        return Storage::disk('avatars')
            ->url('default.jpeg');

//        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
//            return mb_substr($segment, 0, 1);
//        })->join(' '));
//
//        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=FFFFFF&background=6D27D9';
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function avatarDisk()
    {
        return 'avatars';
    }
}
