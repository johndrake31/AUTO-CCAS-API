<?php

namespace App\Entity;

use App\Repository\CarAdRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CarAdRepository::class)
 * 
 */
class CarAd
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"classified"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"classified"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"classified"})
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"classified"})
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"classified"})
     */
    private $kilometers;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classified"})
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classified"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classified"})
     */
    private $fuel;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"classified"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classified"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Garage::class, inversedBy="carAds")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"classified"})
     */
    private $garage;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="carAds")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"classified"})
     */
    private $user;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getKilometers(): ?int
    {
        return $this->kilometers;
    }

    public function setKilometers(int $kilometers): self
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
