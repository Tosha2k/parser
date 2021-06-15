<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $externalId;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $img;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="movies")
     */
    private $category;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $shortDescription;

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

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getImg()
	{
		return $this->img;
	}

	/**
	 * @param mixed $img
	 */
	public function setImg($img): void
	{
		$this->img = $img;
	}

	/**
	 * @return mixed
	 */
	public function getShortDescription()
	{
		return $this->shortDescription;
	}

	/**
	 * @param mixed $shortDescription
	 */
	public function setShortDescription($shortDescription): void
	{
		$this->shortDescription = $shortDescription;
	}


}
