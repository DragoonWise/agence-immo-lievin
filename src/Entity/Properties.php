<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Properties
 *
 * @ORM\Table(name="properties", indexes={@ORM\Index(name="FK_Properties_User", columns={"IdUser"}), @ORM\Index(name="FK_Properties_Address", columns={"IdAddress"}), @ORM\Index(name="FK_Properties_PropertyType", columns={"IdPropertyType"})})
 * @ORM\Entity(repositoryClass="App\Repository\PropertiesRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Properties
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
     * @ORM\Column(name="Label", type="string", length=255, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsRental", type="boolean", nullable=false)
     */
    private $isrental;

    /**
     * @var float
     *
     * @ORM\Column(name="Price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EnergyClass", type="string", length=1, nullable=true, options={"default"="NULL","fixed"=true})
     */
    private $energyclass = null;

    /**
     * @var int
     *
     * @ORM\Column(name="LivingSpace", type="integer", nullable=false)
     */
    private $livingspace;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Rooms", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $rooms = null;

    /**
     * @var int|null
     *
     * @ORM\Column(name="BedRooms", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $bedrooms = null;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IsVisible", type="boolean", nullable=true)
     */
    private $isvisible = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IsTop", type="boolean", nullable=true)
     */
    private $istop = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ref", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $ref = null;

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
     * @Gedmo\Timestampable(on="create")
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

    /**
     * @var \Addresses
     *
     * @ORM\ManyToOne(targetEntity="Addresses",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdAddress", referencedColumnName="Id")
     * })
     */
    private $idaddress;

    /**
     * @var \Propertytypes
     *
     * @ORM\ManyToOne(targetEntity="Propertytypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdPropertyType", referencedColumnName="Id")
     * })
     */
    private $idpropertytype;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdUser", referencedColumnName="Id")
     * })
     */
    private $iduser;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsrental(): ?bool
    {
        return $this->isrental;
    }

    public function setIsrental(bool $isrental): self
    {
        $this->isrental = $isrental;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getEnergyclass(): ?string
    {
        return $this->energyclass;
    }

    public function setEnergyclass(?string $energyclass): self
    {
        $this->energyclass = $energyclass;

        return $this;
    }

    public function getLivingspace(): ?int
    {
        return $this->livingspace;
    }

    public function setLivingspace(int $livingspace): self
    {
        $this->livingspace = $livingspace;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(?int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getIsvisible(): ?bool
    {
        return $this->isvisible;
    }

    public function setIsvisible(?bool $isvisible): self
    {
        $this->isvisible = $isvisible;

        return $this;
    }

    public function getIstop(): ?bool
    {
        return $this->istop;
    }

    public function setIstop(?bool $istop): self
    {
        $this->istop = $istop;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): self
    {
        $this->ref = $ref;

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

    public function getIdaddress(): ?Addresses
    {
        return $this->idaddress;
    }

    public function setIdaddress(?Addresses $idaddress): self
    {
        $this->idaddress = $idaddress;

        return $this;
    }

    public function getIdpropertytype(): ?Propertytypes
    {
        return $this->idpropertytype;
    }

    public function setIdpropertytype(?Propertytypes $idpropertytype): self
    {
        $this->idpropertytype = $idpropertytype;

        return $this;
    }

    public function getIduser(): ?Users
    {
        return $this->iduser;
    }

    public function setIduser(?Users $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
