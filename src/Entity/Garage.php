<?php

namespace App\Entity;

use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

// use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=GarageRepository::class)
 * 
 */
class Garage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"garage", "userApi"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garage", "userApi"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garage"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garage"})
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="garages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"garage"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=CarAd::class, mappedBy="garage", orphanRemoval=true)
     */
    private $carAds;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"garage"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"garage"})
     */
    private $postelcode;

    public function __construct()
    {
        $this->carAds = new ArrayCollection();
    }

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $carAd->setGarage($this);
        }

        return $this;
    }

    public function removeCarAd(CarAd $carAd): self
    {
        if ($this->carAds->removeElement($carAd)) {
            // set the owning side to null (unless already changed)
            if ($carAd->getGarage() === $this) {
                $carAd->setGarage(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostelcode(): ?int
    {
        return $this->postelcode;
    }

    public function setPostelcode(int $postelcode): self
    {
        $this->postelcode = $postelcode;

        return $this;
    }
}
