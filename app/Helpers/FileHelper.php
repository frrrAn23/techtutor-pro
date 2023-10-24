<?php
use Illuminate\Support\Facades\Storage;

if (!function_exists('storeFile')) {
    function storeFile($file, $path, $disk = 'public') {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $fileName, $disk);

        return $path . '/' . $fileName;
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($filePath, $disk = 'public') {
        if ($disk == 'public') {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
    }
}

if (!function_exists('getFile')) {
  function getFile($filePath, $default) {
    if ($filePath == null) {
        return $default;
    }

    if (strpos($filePath, 'https://ui-avatars.com/api/?name=') !== false) {
      return $filePath;
    }

    if (Storage::disk('public')->exists($filePath)) {
        return Storage::disk('public')->url($filePath);
    }

    return $default;
  }
}
