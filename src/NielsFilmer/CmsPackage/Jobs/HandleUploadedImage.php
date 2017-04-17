<?php

namespace NielsFilmer\CmsPackage\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use NielsFilmer\CmsPackage\Jobs\ResizeUploadedImage;

class HandleUploadedImage
{
    use Dispatchable, Queueable;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var int
     */
    protected $quality;

    /**
     * @var string
     */
    protected $disk;

    /**
     * Create a new job instance.
     *
     * @param UploadedFile $file
     * @param array $config
     * @param $extension
     * @param int $quality
     * @param string $disk
     */
    public function __construct(UploadedFile $file, array $config, $extension = null, $quality = 90, $disk = 'cloud')
    {
        $this->config = $config;
        $this->file = $file;
        $this->extension = $extension;
        $this->quality = $quality;
        $this->disk = $disk;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        $storage    = app(FilesystemManager::class);
        $extension = (is_null($this->extension)) ? $this->file->getClientOriginalExtension() : $this->extension;

        if(isset($this->config['size'])) {
            $width      = $this->config['size']['width'];
            $height     = $this->config['size']['height'];
            $local_path = dispatch( new ResizeUploadedImage( $this->file, $width, $height, $extension, $this->quality ) );
        } else {
            $local_path = $this->file->getPathname();
        }

        $filename   = bin2hex( openssl_random_pseudo_bytes( 16 ) ) . ".{$extension}";
        $image_path = "{$this->config['path']}/{$filename}";

        $disk = ($this->disk == 'cloud') ? $storage->cloud() : $storage->disk($this->disk);
        $disk->put( $image_path, fopen( $local_path, 'r' ) );

        try {
            unlink( $local_path );
        } catch(\Exception $e) {
            // Failed to delete local file. Manual cleaning required.
        }

        return $image_path;
    }
}
