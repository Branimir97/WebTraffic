<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=VisitorRepository::class)
 */
class Visitor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $countryName;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $continentName;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $continentCode;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $currencyCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $timezone;

    /**
     * @ORM\Column(type="integer")
     */
    private $spentTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $visitsNumber;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $referer;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getContinentName(): ?string
    {
        return $this->continentName;
    }

    public function setContinentName(string $continentName): self
    {
        $this->continentName = $continentName;

        return $this;
    }

    public function getContinentCode(): ?string
    {
        return $this->continentCode;
    }

    public function setContinentCode(string $continentCode): self
    {
        $this->continentCode = $continentCode;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getSpentTime(): ?int
    {
        return $this->spentTime;
    }

    public function setSpentTime(int $spentTime): self
    {
        $this->spentTime = $spentTime;

        return $this;
    }

    public function getVisitsNumber(): ?int
    {
        return $this->visitsNumber;
    }

    public function setVisitsNumber(int $visitsNumber): self
    {
        $this->visitsNumber = $visitsNumber;

        return $this;
    }

    public function getReferer(): ?string
    {
        return $this->referer;
    }

    public function setReferer(?string $referer): self
    {
        $this->referer = $referer;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
