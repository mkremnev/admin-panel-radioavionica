<?php

declare(strict_types=1);

namespace App\UploadHandler;

use DomainException;
use Psr\Http\Message\UploadedFileInterface;

use function print_r;

class UploadHandler
{
    private string $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function moveUploadedFile(UploadedFileInterface $uploadedFile): string
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        print_r($this->directory);

        try {
            $basename = bin2hex(random_bytes(8));
        } catch (DomainException $e) {
            throw new DomainException('Error convert binary data into hexadecimal representation');
        }

        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($this->directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
