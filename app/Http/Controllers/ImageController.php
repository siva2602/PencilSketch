<?php

namespace App\Http\Controllers;

use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function pencilSketch(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        try {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);

            $imagePath = public_path('images/' . $filename);

            $image = Image::make($imagePath);

            $image->greyscale()
                ->brightness(35)
                ->sharpen(100)->contrast(40)->pixelate(1)->colorize(50, 50, 50);

            $image->sharpen(100)->colorize(50, 50, 50);

            $image->blur(1);
            $convertImageName = time() . '_convert_' . $filename;
            $sketchPath = public_path('images/'. $convertImageName);
            $image->save($sketchPath);

            return view('welcome', [
                'orginal' => '/images/' . $filename,
                'convert' => '/images/' . $convertImageName,
                'isTrue' => true
            ]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }
}
