<?php


namespace App\Service;


use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;

class MoviesManager
{
	private $em;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->em = $entityManager;
	}

    public function getMoviesTopByAllCategories(\DateTime $dateTime): array
    {
        $result = [];
        $categories = $this->em->getRepository(Category::class)->findAll();
        foreach ($categories as $category) {
            $movies = $this->em->getRepository(Rating::class)->findTop($dateTime, $category->getId());

            $result[] = [
                'name' => $category->getName(),
                'movies' => $movies
            ];
        }
        return $result;
    }

    public function saveListMovies(array $moviesItems)
    {

        foreach ($moviesItems as $movieItem){

            $movie = $this->em->getRepository(Movie::class)->findOneBy(array('externalId'=>$movieItem['externalId']));
            $category = $this->em->getRepository(Category::class)->find($movieItem['categoryId']);
            if (is_int($movieItem['rating']) && is_float($movieItem['estimatedScore'])) {
                if (!$movie){
                    $movie = new Movie();
                }

                $movie->setName($movieItem['name']);
                $movie->setExternalId(intval($movieItem['externalId']));
                $movie->setImg($movieItem['poster']);
                $movie->setShortDescription($movieItem['description']);
                $movie->setCategory($category);
                $this->em->persist($movie);

                $date = new \DateTime();
                $rating = $this->em->getRepository(Rating::class)->findOneBy(array('date'=>$date, 'movie'=>$movie));
                if(!$rating){
                    $rating = new Rating();
                    $rating->setDate($date);
                    $rating->setMovie($movie);
                }
                if (is_float($movieItem['averageScore'])){
                    $rating->setAverageScore($movieItem['averageScore']);
                }

                if (is_float($movieItem['estimatedScore'])){
                    $rating->setEstimatedScore($movieItem['estimatedScore']);
                }

                $rating->setVoices($movieItem['voices']);
                $rating->setPosition($movieItem['rating']);
                $this->em->persist($rating);
            }

            $this->em->flush();
        }

    }
}