<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAdmin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="users")
     */
    private $groups;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    public function __construct() {
        $this->groups = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self {
        $this->lastName = $lastName;

        return $this;
    }

    public function getName() {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getIsAdmin(): ?bool {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection {
        return $this->groups;
    }

    public function addGroup(Group $group): self {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addUser($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeUser($this);
        }

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self {
        $this->updated = $updated;

        return $this;
    }

    public function __toString() {
        return $this->getName();
    }
}
