<?php

namespace App\Entity;

use App\Repository\CampaignsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampaignsRepository::class)
 */
class Campaigns
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $creation_user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $creation_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $registration_name_button;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnailImageFilename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lanscapeImageFilename;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $stop_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationUserId(): ?int
    {
        return $this->creation_user_id;
    }

    public function setCreationUserId(int $creation_user_id): self
    {
        $this->creation_user_id = $creation_user_id;

        return $this;
    }

    public function getCreationDate(): ?string
    {
        return $this->creation_date;
    }

    public function setCreationDate(string $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getRegistrationNameButton(): ?string
    {
        return $this->registration_name_button;
    }

    public function setRegistrationNameButton(string $registration_name_button): self
    {
        $this->registration_name_button = $registration_name_button;

        return $this;
    }

    public function getThumbnailImageFilename(): ?string
    {
        return $this->thumbnailImageFilename;
    }

    public function setThumbnailImageFilename(string $thumbnailImageFilename): self
    {
        $this->thumbnailImageFilename = $thumbnailImageFilename;

        return $this;
    }

    public function getLanscapeImageFilename(): ?string
    {
        return $this->lanscapeImageFilename;
    }

    public function setLanscapeImageFilename(string $lanscapeImageFilename): self
    {
        $this->lanscapeImageFilename = $lanscapeImageFilename;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getStopDate(): ?\DateTimeInterface
    {
        return $this->stop_date;
    }

    public function setStopDate(?\DateTimeInterface $stop_date): self
    {
        $this->stop_date = $stop_date;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }
}
