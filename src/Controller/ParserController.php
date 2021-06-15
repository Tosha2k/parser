<?php


namespace App\Controller;


use App\Entity\Category;
use App\Service\MoviesManager;
use App\Service\WordArtParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ParserController extends AbstractController
{
	public function parseList(Request $request, WordArtParser $wordArtParser, MoviesManager $moviesManager): JsonResponse
	{
		$categoryId = $request->query->get('category', 1);
		$category   = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($categoryId);
		$limit      = $request->query->get('limit', 0);

		$data = $wordArtParser->parseListPage($limit, $category);
		$data = $wordArtParser->parseAllCinemaByCategories($category);

		$moviesManager->saveListMovies($data);

		return $this->json(['status' => 'ok']);
	}

	public function parseAllCategories(WordArtParser $wordArtParser)
	{
		$categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
		foreach ($categories as $category) {
			$wordArtParser->parseAllCinemaByCategories($category);
		}
	}
}