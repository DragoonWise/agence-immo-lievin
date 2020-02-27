<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Properties
 *
 * @ORM\Table(name="properties", indexes={@ORM\Index(name="FK_Properties_User", columns={"IdUser"}), @ORM\Index(name="FK_Properties_Address", columns={"IdAddress"}), @ORM\Index(name="FK_Properties_PropertyType", columns={"IdPropertyType"})})
 * @ORM\Entity(repositoryClass="App\Repository\PropertiesRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
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
     * @ORM\Column(name="IsVisible", type="boolean", nullable=false,options={"default"="0"})
     */
    private $isvisible = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IsTop", type="boolean", nullable=false,options={"default"="0"})
     */
    private $istop = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Ref", type="string", length=50, nullable=false)
     */
    private $ref = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created_at", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Updated_at", type="datetime", nullable=false, options={"default"="current_timestamp()"})
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
     * @var bool
     *
     * @ORM\Column(name="Deleted", type="boolean", nullable=false, options={"default"="0"})
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

    /**
     * @var Collection|\Pictures[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Pictures", mappedBy="idproperty",cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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

    /**
     * @return Collection|Pictures[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Pictures $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setIdProperty($this);
        }

        return $this;
    }

    public function removeImage(Pictures $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getIdProperty() === $this) {
                $image->setIdProperty(null);
            }
        }

        return $this;
    }

    public function setImage1($d):self
    {
        // var_dump($d);
        // exit;
        $tmp = $this->getImage1();
        if (!is_null($tmp) && ($tmp->imagename != $d->originalName))
        {
            $this->removeImage($tmp);
        }
        if (is_null($tmp))
        {
            $filename = $this->id . '_' . Uuid::uuid4()->toString();
            move_uploaded_file($d->getfileName(), "build/images/$filename");
            // download image puis stock le nouveau nom dans $filename
            $picture = new Pictures();
            $picture->setImageName($filename);
            $picture->setidproperty($this); // Id non affecté pour les nouveaux biens
            $this->addImage($picture);
        }
        return $this;
    }

    public function getImage1() : ?File
    {
        if (count($this->images)>0)
            return $this->images[0];
            // var_dump(new Pictures);
        return null;
    }

    public function setImage2($d):self
    {
        return $this;
    }

    public function getImage2() : ?File
    {
        if (count($this->images)>1)
            return $this->images[1];
            // var_dump(new Pictures);
        return null;
    }

    public function setImage3($d):self
    {
        return $this;
    }

    public function getImage3() : ?File
    {
        if (count($this->images)>2)
            return $this->images[2];
            // var_dump(new Pictures);
        return null;
    }


}
