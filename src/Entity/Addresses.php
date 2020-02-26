<?php

namespace App\Entity;

use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Addresses
 *
 * @ORM\Table(name="addresses")
 * @ORM\Entity(repositoryClass="App\Repository\AddressesRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Addresses
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
     * @ORM\Column(name="Address1", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $address1 = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address2", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $address2 = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address3", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $address3 = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address4", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $address4 = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="PostCode", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $postcode = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="City", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $city = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="State", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $state = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Country", type="string", length=80, nullable=true, options={"default"="NULL"})
     */
    private $country = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created_at", type="datetime", nullable=false, options={"default"="current_timestamp()"})
   * @Gedmo\Timestampable(on="create")
       */
    private $createdAt ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Updated_at", type="datetime", nullable=false, options={"default"="current_timestamp()"})
  * @Gedmo\Timestampable(on="update")
        */
    private $updatedAt;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getAddress3(): ?string
    {
        return $this->address3;
    }

    public function setAddress3(?string $address3): self
    {
        $this->address3 = $address3;

        return $this;
    }

    public function getAddress4(): ?string
    {
        return $this->address4;
    }

    public function setAddress4(?string $address4): self
    {
        $this->address4 = $address4;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

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
