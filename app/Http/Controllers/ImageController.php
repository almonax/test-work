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
     * @param   Request $request
     * @return  string
     */
    public function resizeImage(Request $request)
    {
        $Image = new ImageManager(['driver' => 'gd']);
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $uploadPath = $this->generPath($this->pathOrigin);
        $thumbPath = $this->generPath($this->pathResize);
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
     * @param   string $folder
     * @return  string
     */
    private function generPath($folder)
    {
        return public_path($this->defaultPath
            . DIRECTORY_SEPARATOR
            . $folder
            . DIRECTORY_SEPARATOR
            . $this->subPath
            . DIRECTORY_SEPARATOR);
    }

    /**
     * @param   string $path
     * @return  bool
     */
    private function checkDir($path)
    {
        if (file_exists($path)) {
            return true;
        } else {
            $Filesys = new Filesystem();
            return$Filesys->makeDirectory($path, 0755, true);
        }
    }



}
