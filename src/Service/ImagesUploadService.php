<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class ImagesUploadService
{
    public function uploadNewImage($pictureFileName,$slugger)
    {
        try {
            $oryginalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($oryginalFileName);
            $newFileNamePhoto = $safeFilename . '-' . uniqid() . '.' . $pictureFileName->guessExtension();
            $pictureFileName->move('download/', $newFileNamePhoto);
            return $newFileNamePhoto;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function uploadEditImage($pictureFileName,$oldFilePath,$slugger)
    {
        $filesystem = new Filesystem();
        try {
            $filesystem->remove(['download/' . $oldFilePath]);
            $oryginalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($oryginalFileName);
            $newFileNamePhoto = $safeFilename . '-' . uniqid() . '.' . $pictureFileName->guessExtension();
            $pictureFileName->move('download/', $newFileNamePhoto);
            return $newFileNamePhoto;
        } catch (\Exception $e) {
            return false;
        }
    }
}
