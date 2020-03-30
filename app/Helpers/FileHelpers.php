<?php

namespace App\Helpers;

use Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class FileHelpers {

	public static function store($image, $directory) {

    	$extension = $image->getClientOriginalExtension() ? $image->getClientOriginalExtension() : 'jpg';

    	$optimized_image = Image::make($image)->encode($extension);

    	$width = $optimized_image->getWidth();
	    $height = $optimized_image->getHeight();

	    if ($width >= $height) {
	    	$optimized_image->resize(700, null, function ($constraint) {
			    $constraint->aspectRatio();
			    $constraint->upsize();
			});
	    } else {
	    	$optimized_image->resize(null, 700, function ($constraint) {
			    $constraint->aspectRatio();
			    $constraint->upsize();
			});
	    }

	    $optimized_image->save();

	    switch (config('web.filesystem')) {
	    	case 's3':
	    			$root = null;
	    		break;
	    	
	    	default:
	    			$image->store($directory, 'public');
	    			$root = 'public/';
	    		break;
	    }

	    $file_path = $root . $directory . '/' . uniqid() . Str::random(40) . '.' . $extension;

    	Storage::put($file_path, $optimized_image);

    	return $file_path;
	}

	public static function getExternalImage($url) {
    	$info = pathinfo($url);
		$contents = file_get_contents($url);
		$file = '/tmp/' . $info['basename'];
		file_put_contents($file, $contents);
		return new UploadedFile($file, $info['basename']);
	}
}