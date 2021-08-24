<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

// use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * 
 */

class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"userApi", "garage"})
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     * @Groups({"userApi"})
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userApi", "garage"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userApi", "garage"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userApi", "garage"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userApi"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"userApi"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"userApi"})
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Garage::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"userApi"})
     * @Assert\NotBlank(allowNull = true)
     */
    private $garages;

    /**
     * @ORM\OneToMany(targetEntity=CarAd::class, mappedBy="user", orphanRemoval=true)
     * @Groups({"userApi"})
     * @Assert\NotBlank(allowNull = true)
     */
    private $carAds;

    public function __construct()
    {
        $this->garages = new ArrayCollection();
        $this->carAds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier()
    {
        return $this->username;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Garage[]
     */
    public function getGarages(): Collection
    {
        return $this->garages;
    }

    public function addGarage(Garage $garage): self
    {
        if (!$this->garages->contains($garage)) {
            $this->garages[] = $garage;
            $garage->setUser($this);
        }

        return $this;
    }

    public function removeGarage(Garage $garage): self
    {
        if ($this->garages->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getUser() === $this) {
                $garage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CarAd[]
     */
    public function getCarAds(): Collection
    {
        return $this->carAds;
    }

    public function addCarAd(CarAd $carAd): self
    {
        if (!$this->carAds->contains($carAd)) {
            $this->carAds[] = $carAd;
            $carAd->setUser($this);
        }

        return $this;
    }

    public function removeCarAd(CarAd $carAd): self
    {
        if ($this->carAds->removeElement($carAd)) {
            // set the owning side to null (unless already changed)
            if ($carAd->getUser() === $this) {
                $carAd->setUser(null);
            }
        }

        return $this;
    }
}
