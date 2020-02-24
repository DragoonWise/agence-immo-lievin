<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Propertytypes
 *
 * @ORM\Table(name="propertytypes")
 * @ORM\Entity(repositoryClass="App\Repository\PropertyTypesRepository")
 */
class Propertytypes
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
     * @var string
     *
     * @ORM\Column(name="Label", type="string", length=50, nullable=false)
     */
    private $label;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Created_at", type="datetime", nullable=true, options={"default"="current_timestamp()"})
   * @Gedmo\Timestampable(on="create")
     */
    private $createdAt = null;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Updated_at", type="datetime", nullable=true, options={"default"="current_timestamp()"})
    * @Gedmo\Timestampable(on="update")
    */
    private $updatedAt = null;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Deleted_at", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $deletedAt = null;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Deleted", type="boolean", nullable=true)
     */
    private $deleted = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }


}
