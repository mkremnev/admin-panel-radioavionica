<?php

declare(strict_types=1);

namespace App\Military\Command\AddDefect;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     */
    //private string $token; //TODO ждет реализации token->access

    /**
     * @Assert\NotBlank
     */
    public string $unit;

    /**
     * @Assert\NotBlank
     */
    public string $responsible;

    /**
     * @Assert\NotBlank
     */
    public string $district;

    /**
     * @Assert\NotBlank
     */
    public string $amount;

    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $deliveryYear = null;

    /**
     * @Assert\Regex("/^[0-9.]/")
     */
    public ?string $commissioningDate = null;

    /**
     * @Assert\Regex("/^\d/")
     */
    public ?string $warranty = null;

    /**
     * @Assert\Regex("/^\d/")
     */
    public ?string $nonWarranty = null;

    /**
     * @Assert\Regex("/^\d/")
     */
    public ?string $component = null;

    /**
     * @Assert\Regex("/^\d/")
     */
    public ?string $mik = null;

    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $ak1 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $pkk = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $kpe1 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $kab004 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $kab136 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $kab137 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $zu = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $zupkk = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $mfp = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $pou = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $mirs = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $msns = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $kab152 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $kab153 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $tmg36 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $gvsh = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $pdu = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $r168 = null;
    /**
     * @Assert\Regex("/^\d+/")
     */
    public ?string $r438 = null;

    public ?array $notes = null;
}
