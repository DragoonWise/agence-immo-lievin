<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="FK_Users_Address", columns={"IdAddress"})})
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Users implements UserInterface
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
     * @ORM\Column(name="Email", type="string", length=255, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $password = null;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LastName", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $lastname = null;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FirstName", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $firstname = null;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="IsAdmin", type="boolean", nullable=true)
     */
    private $isadmin = '0';

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        if (!is_null($password) && password_needs_rehash($password, PASSWORD_BCRYPT))
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getIsadmin(): ?bool
    {
        return $this->isadmin;
    }

    public function setIsadmin(?bool $isadmin): self
    {
        $this->isadmin = $isadmin;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];
        // guarantee every user at least has ROLE_USER
        if ($this->getisadmin())
            $roles[] = 'ROLE_ADMIN';
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
