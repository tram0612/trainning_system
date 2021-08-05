<?php
namespace App\Http\Traits;
trait UploadFile
{
    /**
     * get current user from token
     * 
     * @return string
     */
    protected function upload($file)
    {
        $name = rand(0,100).$file->getClientOriginalName();
        $storedPath = $file->move('upload/', $name);
        return $name;
    }
}

    