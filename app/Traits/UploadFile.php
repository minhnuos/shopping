<?php
    namespace App\Traits;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    Trait UploadFile {
        public function uploadFile($folder, $fieldName,$request) {
            if($request->hasFile($fieldName)) {
                $file = $request->$fieldName;
                $nameFileRandom = Str::random(20) . '.' . $file->extension();
                $fileUpload = $request->file($fieldName)->storeAs('public/' . $folder . '/' . Auth::id(),  $nameFileRandom);
                $path =  Storage::url($fileUpload);
                return $path;
            }
            return null;
        }
    }
?>
