<?php

namespace App\Services\Utils;

use App\Services\Utils\FileServiceInterface;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    private $basePath;
    public function  __construct() {
        $this->basePath = config('storage.base_path');
    }

    public function download($path, $encryptionKey)
    {
        $encryptedFileContents = Storage::disk('local')->get($path);
        $decryptedFileContents = Crypt::decrypt($encryptedFileContents, $encryptionKey);
        return $decryptedFileContents;
    }

    public function upload($folderName, $fileName, $file, $key)
    {
        $folderName = $this->basePath . $folderName;
        $encryptedContents = Crypt::encrypt($file, $key);
        Storage::disk('local')->put($folderName . '/' . $fileName, $encryptedContents);
        return $folderName . '/' . $fileName;
    }
}
