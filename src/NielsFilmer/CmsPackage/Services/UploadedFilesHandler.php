<?php
/**
 * Created by PhpStorm.
 * User: filme
 * Date: 10/13/2017
 * Time: 14:25
 */

namespace NielsFilmer\CmsPackage\Services;


use Illuminate\Bus\Queueable;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;


class UploadedFilesHandler
{
    /**
     * @param UploadedFile $file
     * @param null $width
     * @param null $height
     * @param string $extension
     * @param int $quality
     * @return string
     */
    public function resize(UploadedFile $file, $width = null, $height = null, $extension = "jpg", $quality = 90)
    {
        $tmp_dir = config('filesystems.disks.local.root') . "/temp";
        if(!is_dir($tmp_dir)) mkdir($tmp_dir);
        $tmpfile = "$tmp_dir/" . uniqid('image-') . ".{$extension}";

        /** @var \Intervention\Image\Image $image */
        $image = Image::make($file->getPathname());
        $org_width = $image->width();
        $org_height = $image->height();

        if(!is_null($width) && !is_null($height)) {
            if($org_width > $width && $org_height > $height) {
                $image->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });
            } else if($org_width > $width) {
                $image->widen($width, function ($constraint) {
                    $constraint->upsize();
                });
            } else if($org_height > $height) {
                $image->heighten($height, function ($constraint) {
                    $constraint->upsize();
                });
            }
        } else if(is_null($width) && $org_height > $height) {
            $image->heighten($height, function ($constraint) {
                $constraint->upsize();
            });
        } else if (is_null($height) && $org_width > $width) {
            $image->widen($width, function ($constraint) {
                $constraint->upsize();
            });
        }

        $image->orientate()->save($tmpfile, $quality);
        return $tmpfile;
    }


    /**
     * @param UploadedFile $file
     * @param array $config
     * @param null $extension
     * @param int $quality
     * @param string $disk
     * @return string
     */
    public function handle(UploadedFile $file, array $config, $extension = null, $quality = 90, $disk = 'cloud')
    {
        $storage    = app(FilesystemManager::class);
        $extension = (is_null($extension)) ? $file->getClientOriginalExtension() : $extension;

        if(isset($config['size'])) {
            $width      = $config['size']['width'];
            $height     = $config['size']['height'];
            $local_path = $this->resize( $file, $width, $height, $extension, $quality );
            $destructive = true;
        } else {
            $local_path = $file->getPathname();
            $destructive = false;
        }

        $filename   = bin2hex( openssl_random_pseudo_bytes( 16 ) ) . ".{$extension}";
        $image_path = "{$config['path']}/{$filename}";

        $disk = ($disk == 'cloud') ? $storage->cloud() : $storage->disk($disk);
        $disk->put( $image_path, fopen( $local_path, 'r' ) );

        if($destructive) {
            try {
                unlink( $local_path );
            } catch(\Exception $e) {
                // Failed to delete local file. Manual cleaning required.
            }
        }

        return $image_path;
    }
}