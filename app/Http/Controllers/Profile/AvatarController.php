<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateAvatarRequest;

class AvatarController extends Controller
{
    //
    public function update(UpdateAvatarRequest $request)
    {
        $path =Storage::disk('public')->put('avatars', $request->file('avatar'));
        // $path = $request->file('avatar')->store('avatars', 'public');
       
        // To remove the old avatar
        if ($oldAvatar = $request->user()->avatar){
            Storage::disk('public')->delete($oldAvatar);
        }
       
        auth()->user()->update(['avatar' => $path]);
        // store avatar
        return redirect(route('profile.edit'))->with('message', 'Avatar is updated');
    }
}
