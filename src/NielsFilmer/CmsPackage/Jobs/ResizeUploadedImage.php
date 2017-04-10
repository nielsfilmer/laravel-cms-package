<?php

namespace NielsFilmer\CmsPackage\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ResizeUploadedImage
{
    use Dispatchable, Queueable;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var integer|null
     */
    protected $width;

    /**
     * @var integer|null
     */
    protected $height;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var int
     */
    protected $quality;

    /**
     * Create a new job instance.
     *
     * @param UploadedFile $file
     * @param $width
     * @param null $height
     * @param string $extension
     * @param int $quality
     */
    public function __construct(UploadedFile $file, $width = null, $height = null, $extension = "jpg", $quality = 90)
    {
        $this->file = $file;
        $this->width = $width;
        $this->height = $height;
        $this->extension = $extension;
        $this->quality = $quality;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $tmp_dir = config('filesystems.disks.local.root') . "/temp";
        if(!is_dir($tmp_dir)) mkdir($tmp_dir);
        $tmpfile = "$tmp_dir/" . uniqid('image-') . ".{$this->extension}";

        /** @var \Intervention\Image\Image $image */
        $image = Image::make($this->file->getPathname());

        if(is_null($this->width)) {
            $image->heighten($this->height, function ($constraint) {
                $constraint->upsize();
            });
        } else if (is_null($this->height)) {
            $image->widen($this->width, function ($constraint) {
                $constraint->upsize();
            });
        } else {
            $image->fit($this->width, $this->height, function ($constraint) {
                $constraint->upsize();
            });
        }

        $image->orientate()->save($tmpfile, $this->quality);
        return $tmpfile;
    }
}
