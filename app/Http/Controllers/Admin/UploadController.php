<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageupload(Request $request) {
        $request->validate([
            'files' => ['required', 'image', 'mimes:jpeg,jpg,png']
        ]);

        dd($request);
        exit;
        $imageName = time().'.'.$request->file->extension();

        $request->file->move(public_path('media/images'), $imageName);

        return [
            'location' => asset('media/images/'.$imageName)
        ];
    }
}
