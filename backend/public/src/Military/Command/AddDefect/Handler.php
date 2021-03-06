<?php

declare(strict_types=1);

namespace App\Military\Command\AddDefect;

use App\Flusher;
use App\Military\Entity\Defect\Components;
use App\Military\Entity\Defect\Defect;
use App\Military\Entity\Defect\DefectNote;
use App\Military\Entity\Defect\DefectRepository;
use App\Military\Entity\Defect\District;
use App\Military\Entity\Defect\Fault;
use App\Military\Entity\Defect\Id;
use App\Military\Entity\Defect\Note;
use App\Military\Entity\Defect\Unit;

class Handler
{
    private Flusher $flusher;
    private DefectRepository $defects;

    /**
     * Handler constructor.
     * @param Flusher $flusher
     * @param DefectRepository $defects
     */
    public function __construct(Flusher $flusher, DefectRepository $defects)
    {
        $this->flusher = $flusher;
        $this->defects = $defects;
    }

    public function handle(Command $command): void
    {
        $unit = new Unit($command->unit);
        $district = new District($command->district);
        $fault = new Fault($command->component, $command->mik);

        $components = new Components(
            $command->ak1,
            $command->pkk,
            $command->kpe1,
            $command->kab004,
            $command->kab136,
            $command->kab137,
            $command->zu,
            $command->zupkk,
            $command->mfp,
            $command->pou,
            $command->mirs,
            $command->msns,
            $command->kab152,
            $command->kab153,
            $command->tmg36,
            $command->gvsh,
            $command->pdu,
            $command->r168,
            $command->r438
        );

        $defect = new Defect(
            Id::generate(),
            $unit,
            $command->responsible,
            $district,
            $command->amount,
            $command->deliveryYear,
            $command->commissioningDate,
            $command->warranty,
            $command->nonWarranty,
            $fault,
            $components
        );

        if ($command->notes) {
            foreach ($command->notes as $note) {
                $attachNote = new Note($note);
                $defect->attachNotes($attachNote);
            }
        }

        $this->defects->add($defect);

        $this->flusher->flush();
    }
}
