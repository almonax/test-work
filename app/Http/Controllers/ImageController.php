<?php

namespace App\Http\Controllers;

use Mockery\Exception;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Filesystem\Filesystem;

class ImageController extends Controller
{

    /**
     * @var string
     */
    private $defaultPath = 'images';

    /**
     * @var string
     */
    private $pathOrigin = 'uploads';

    /**
     * @var string
     */
    private $pathResize = 'thumbs';

    /**
     * @var string
     */
    private $subPath;

    /**
     * @var int
     */
    private $width = 100;

    /**
     * @var int
     */
    private $height = 100;

    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->subPath = date('Y')
            .'/'. date('m')
            .'/'. date('d');
    }

    /**
     * Resize image on init params
     *
     * @param   Request $request
     * @return  string
     */
    public function resizeImage(Request $request)
    {
        $Image = new ImageManager(['driver' => 'gd']);
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $uploadPath = $this->generPath([
            $this->pathOrigin,
            $this->subPath
        ]) . '/';
        $thumbPath = $this->generPath([
            $this->pathResize,
            $this->subPath
        ]) . '/';
        $image = $request->file('photo');
        $imageName = time() .'.'. $image->getClientOriginalExtension();

        if (! $this->checkDir($uploadPath) || ! $this->checkDir($thumbPath))
            throw new Exception('Can`t create directory', 500);

        $img = $Image->make($image->getRealPath());
        $img->fit($this->width, $this->height)->save($thumbPath . $imageName);

        $image->move($uploadPath, $imageName);

        return $this->subPath .'/'. $imageName;
    }

    /**
     * Delete photo (re-size and original version) from folders
     *
     * @param   string $path
     */
    public function deletePhoto($path)
    {
        $FileSys = new Filesystem();

        $toUploads = $this->generPath([
            $this->pathOrigin,
            $path
        ]);
        $toThumbs = $this->generPath([
            $this->pathResize,
            $path
        ]);

        if (file_exists($toUploads))
            $FileSys->delete($toUploads);
        if (file_exists($toThumbs))
            $FileSys->delete($toThumbs);
    }

    /**
     * Helpers function. Generated path to download folders
     *
     * @param   array $paths
     * @return  string
     */
    private function generPath($paths)
    {
        $fullPath = $this->defaultPath . DIRECTORY_SEPARATOR;
        foreach ($paths as $path) {
            if ($path != last($paths))
                $fullPath .= $path . DIRECTORY_SEPARATOR;
            else
                $fullPath .= $path;
        }
        return public_path($fullPath);
    }

    /**
     * Helpers function. Checked path on existed directories
     * if dir not found - created it.
     *
     * @param   string $path
     * @return  bool
     */
    private function checkDir($path)
    {
        if (file_exists($path)) {
            return true;
        } else {
            $Filesys = new Filesystem();
            return $Filesys->makeDirectory($path, 0744, true);
        }
    }



}
