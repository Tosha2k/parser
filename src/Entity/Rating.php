<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $estimatedScore;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averageScore;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $voices;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getEstimatedScore(): ?float
    {
        return $this->estimatedScore;
    }

    public function setEstimatedScore(?float $estimatedScore): self
    {
        $this->estimatedScore = $estimatedScore;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getAverageScore()
	{
		return $this->averageScore;
	}

	/**
	 * @param mixed $averageScore
	 */
	public function setAverageScore($averageScore): void
	{
		$this->averageScore = $averageScore;
	}

	/**
	 * @return mixed
	 */
	public function getVoices()
	{
		return $this->voices;
	}

	/**
	 * @param mixed $voices
	 */
	public function setVoices($voices): void
	{
		$this->voices = $voices;
	}

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

	/**
	 * @return mixed
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param mixed $date
	 */
	public function setDate($date): void
	{
		$this->date = $date;
	}


}
