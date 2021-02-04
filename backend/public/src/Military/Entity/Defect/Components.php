<?php

declare(strict_types=1);

namespace App\Military\Entity\Defect;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Components
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $ak1;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $pkk;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $kpe1;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $kab004;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $kab136;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $kab137;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $zu;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $zupkk;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $mfp;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $pou;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $mirs;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $msns;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $kab152;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $kab153;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $tmg36;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $gvsh;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $pdu;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $r168;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private string $r438;

    public function __construct(
        string $ak1,
        string $pkk,
        string $kpe1,
        string $kab004,
        string $kab136,
        string $kab137,
        string $zu,
        string $zupkk,
        string $mfp,
        string $pou,
        string $mirs,
        string $msns,
        string $kab152,
        string $kab153,
        string $tmg36,
        string $gvsh,
        string $pdu,
        string $r168,
        string $r438
    ) {
        $this->ak1 = $ak1;
        $this->pkk = $pkk;
        $this->kpe1 = $kpe1;
        $this->kab004 = $kab004;
        $this->kab136 = $kab136;
        $this->kab137 = $kab137;
        $this->zu = $zu;
        $this->zupkk = $zupkk;
        $this->mfp = $mfp;
        $this->pou = $pou;
        $this->mirs = $mirs;
        $this->msns = $msns;
        $this->kab152 = $kab152;
        $this->kab153 = $kab153;
        $this->tmg36 = $tmg36;
        $this->gvsh = $gvsh;
        $this->pdu = $pdu;
        $this->r168 = $r168;
        $this->r438 = $r438;
    }

    /**
     * @return string
     */
    public function getAk1(): string
    {
        return $this->ak1;
    }

    /**
     * @return string
     */
    public function getPkk(): string
    {
        return $this->pkk;
    }

    /**
     * @return string
     */
    public function getKpe1(): string
    {
        return $this->kpe1;
    }

    /**
     * @return string
     */
    public function getKab004(): string
    {
        return $this->kab004;
    }

    /**
     * @return string
     */
    public function getKab136(): string
    {
        return $this->kab136;
    }

    /**
     * @return string
     */
    public function getKab137(): string
    {
        return $this->kab137;
    }

    /**
     * @return string
     */
    public function getZu(): string
    {
        return $this->zu;
    }

    /**
     * @return string
     */
    public function getZupkk(): string
    {
        return $this->zupkk;
    }

    /**
     * @return string
     */
    public function getMfp(): string
    {
        return $this->mfp;
    }

    /**
     * @return string
     */
    public function getPou(): string
    {
        return $this->pou;
    }

    /**
     * @return string
     */
    public function getMirs(): string
    {
        return $this->mirs;
    }

    /**
     * @return string
     */
    public function getMsns(): string
    {
        return $this->msns;
    }

    /**
     * @return string
     */
    public function getKab152(): string
    {
        return $this->kab152;
    }

    /**
     * @return string
     */
    public function getKab153(): string
    {
        return $this->kab153;
    }

    /**
     * @return string
     */
    public function getTmg36(): string
    {
        return $this->tmg36;
    }

    /**
     * @return string
     */
    public function getGvsh(): string
    {
        return $this->gvsh;
    }

    /**
     * @return string
     */
    public function getPdu(): string
    {
        return $this->pdu;
    }

    /**
     * @return string
     */
    public function getR168(): string
    {
        return $this->r168;
    }

    /**
     * @return string
     */
    public function getR438(): string
    {
        return $this->r438;
    }
}
