<?php

namespace App\Traits;

use Storage;
use App\Helpers\FileHelpers;

trait FileTrait {

    /* Store Image */
	public function storeImage($file, $column = 'image_path', $directory = 'images') {
        if($this[$column] && Storage::exists('public/' . $this[$column])) {
            Storage::delete('public/' . $this[$column]);
        }

        $this[$column] = FileHelpers::store($file, $directory);
        $this->save();
	}

    public function renderImagePath($column = 'image_path') {
        $path = null;

        if ($this[$column]) {
            $path = url('/') . Storage::url($this[$column]);
        }

        return $path;
    }

    public function renderFilePath($column = 'file_path') {
        $path = null;

        if ($this[$column]) {
            $path = url('/') . Storage::url($this[$column]);
        }

        return $path;
    }
}

