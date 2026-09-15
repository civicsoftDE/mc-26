<?php

namespace App\Service;

use Exception;
use Random\RandomException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class UuidNamerService implements NamerInterface
{
    /**
     * @throws RandomException
     * @throws Exception
     */
    public function name(object $object, PropertyMapping $mapping): string
    {
        // Hole die hochgeladene Datei
        $file = $mapping->getFile($object);

        if (!$file instanceof UploadedFile) {
            throw new Exception('Keine gültige Datei gefunden.');
        }

        // Generiere eine UUID (ohne Bindestriche, optional)
        $uuid = str_replace('-', '', bin2hex(random_bytes(16)));

        // Hole die Original-Endung (z.B. .jpg, .png)
        $extension = $file->guessExtension(); // Oder $file->getExtension()

        // Falls guessExtension() null zurückgibt, Fallback auf clientOriginalName Extension
        if (null === $extension) {
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        }

        return sprintf('%s.%s', $uuid, $extension);
    }

}
