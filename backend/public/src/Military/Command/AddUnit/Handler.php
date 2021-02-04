<?php

declare(strict_types=1);

namespace App\Military\Command\AddUnit;

use App\Flusher;
use App\Military\Entity\Units\Address;
use App\Military\Entity\Units\Name;
use App\Military\Entity\Units\Commander;
use App\Military\Entity\Units\Id;
use App\Military\Entity\Units\Official;
use App\Military\Entity\Units\Unit;
use App\Military\Entity\Units\UnitRepository;
use App\UploadHandler\UploadHandler;
use DomainException;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Psr7\UploadedFile;

class Handler
{
    private UnitRepository $units;
    private Flusher $flusher;
    private UploadHandler $upload;

    public function __construct(UnitRepository $units, Flusher $flusher, UploadHandler $upload)
    {
        $this->units = $units;
        $this->flusher = $flusher;
        $this->upload = $upload;
    }

    public function handle(Command $command): void
    {
        $name = new Name($command->name);

        if ($this->units->hasByName($name)) {
            throw new DomainException("Unit already exist.");
        }

        $address = new Address($command->address);
        $commander = new Commander(
            $command->lastname,
            $command->firstname,
            $command->surname
        );
        $unit = new Unit(
            Id::generate(),
            $name,
            $address,
            $commander,
            $command->amount
        );

        if ($command->officials) {
            foreach ($command->officials as $official) {
                $attachOfficial = new Official(
                    $official['subunit'],
                    $official['rank'],
                    $official['fio'],
                    $official['telephone']
                );

                $unit->attachOfficials($attachOfficial);
            }
        }

        if ($command->files) {
            $files = $command->files;
            /** @var UploadedFileInterface $files  */
            $filename = $this->upload->moveUploadedFile($files);
            $unit->attachFiles($filename);
        }

        $this->units->add($unit);

        $this->flusher->flush();
    }
}
