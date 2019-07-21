<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     mercure=true,
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 150)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @Assert\GreaterThan(0)
     */
    private $price;

    /**
     * @var string
     * @Groups({"read"})
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max = 500)
     */
    private $media;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * @param mixed $media
     * @return Product
     */
    public function setMedia($media): self
    {
        $this->media = $media;
        return $this;
    }

}
