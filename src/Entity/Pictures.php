<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Pictures
 *
 * @ORM\Table(name="pictures")
 * @ORM\Entity(repositoryClass="App\Repository\PicturesRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="propertyimage", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Properties", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
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

      /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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
