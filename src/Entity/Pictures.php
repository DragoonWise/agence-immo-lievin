<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Pictures
 *
 * @ORM\Table(name="pictures", indexes={@ORM\Index(name="FK_Pictures_Property", columns={"IdProperty"})})
 * @ORM\Entity(repositoryClass="App\Repository\PicturesRepository")
 */
class Pictures
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ImageName", type="string", length=255, nullable=false, options={"default"="empty.jpg"})
     */
    private $imageName = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created_at", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt = null;

    /**
     * @var \Properties
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Properties")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdProperty", referencedColumnName="Id")
     * })
     */
    private $idproperty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIdproperty(): ?Properties
    {
        return $this->idproperty;
    }

    public function setIdproperty(?Properties $idproperty): self
    {
        $this->idproperty = $idproperty;

        return $this;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}
