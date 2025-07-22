<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class UserUpdateService
{
    public function handle(User $user, array $validated, ?UploadedFile $image = null, ?UploadedFile $image_cover = null): User
    {
        if ($image) {
            $validated['image'] = $this->updateAvatar($user, $image);
        }

        if ($image_cover) {
            $validated['image_cover'] = $this->updateCover($user, $image_cover);
        }

        $user->update($validated);

        return $user;
    }


    protected function updateAvatar(User $user, $image): string
    {
        if ($image) {
            Storage::disk('public')->delete('/avatarImages'.$user->image);
        }
        return basename($image->store('avatarImages', 'public'));
    }

    protected function updateCover(User $user, $image_cover): string
    {
        if ($image_cover) {
            Storage::disk('public')->delete('/profileCoverImages'.$user->image_cover);
        }
        return basename($image_cover->store('profileCoverImages', 'public'));
    }
}

