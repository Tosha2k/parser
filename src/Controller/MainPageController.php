<?php


namespace App\Controller;


use App\Service\MoviesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainPageController extends AbstractController
{
	public function index(MoviesManager $moviesManager, Request $request): Response
	{
		$date = $request->query->get('date', null);

		if ($date) {
			$date = new \DateTime($date);
		} else {
			$date = new \DateTime();
		}

		$cache      = new FilesystemAdapter();
		$categories = $cache->getItem('categories_' . $date->format('Y-m-d'));

		if (!$categories->isHit()) {
			$categories->set($moviesManager->getMoviesTopByAllCategories($date));
			$cache->save($categories);
		}

		return $this->render('base.html.twig', [
			'categories' => $categories->get(),
		]);
	}
}