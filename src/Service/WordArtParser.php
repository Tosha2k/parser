<?php


namespace App\Service;


use App\Entity\Category;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class WordArtParser
{
	const BASE_HREF = 'http://www.world-art.ru/cinema/';
	private $client;


	public function __construct(MoviesManager $moviesManager)
	{
		$this->client = new Client();
	}

	public function parseListPage(int $limit, Category $category): array
	{
		$params = [
			'query' => [
				'public_list_anchor' => $category->getPublicListAnchor(),
				'limit_1'            => $limit,
				'limit_2'            => $limit + 50
			]
		];

		$res  = $this->client->get($category->getUrl(), $params);
		$html = $res->getBody()->getContents();

		$crawler = new Crawler(null, null, self::BASE_HREF);
		$crawler->addHtmlContent($html, 'windows-1251');

		$table = $crawler->filter('table')->eq(9);

		$baseHref   = self::BASE_HREF;
		$movieItems = [];
		try {
			$movieItems = $table->filter('tr')->nextAll()->each(function (Crawler $nodeCrawler) use ($baseHref, $category) {

				$rating         = $nodeCrawler->filterXPath('//td[1]')->text();
				$estimatedScore = $nodeCrawler->filterXPath('//td[3]')->text();
				$voices         = $nodeCrawler->filterXPath('//td[4]')->text();
				$averageScore   = $nodeCrawler->filterXPath('//td[5]')->text();
				$link           = $nodeCrawler->filterXPath('//td[2]/a')->link()->getUri();
				if (intval($rating)) {
					$externalId             = str_replace($baseHref . 'cinema.php?id=', '', $link);
					$data                   = $this->parseInnerPage($externalId);
					$data['rating']         = intval($rating);
					$data['estimatedScore'] = $estimatedScore;
					$data['voices']         = $voices;
					$data['averageScore']   = $averageScore;
					$data['externalId']     = $externalId;
					$data['categoryId']     = $category->getId();

					return $data;
				} else {
					return null;
				}


			});
		} catch (\Exception $ex) {
			echo $ex->getMessage();
		}

		return $movieItems;
	}

	public function parseAllCinemaByCategories(Category $category): array
	{
		$count = 50;
		$arr   = [];
		$i     = 0;
		while ($count >= 50) {
			$cinemaArr = $this->parseListPage($i, $category);
			$arr       = array_merge($arr, $cinemaArr);
			$count     = count($cinemaArr);
			$i         += 50;
		}
		return $arr;
	}

	private function parseInnerPage($id): array
	{
		$params = [
			'query' => [
				'id' => $id,
			]
		];

		$link = 'http://www.world-art.ru/cinema/cinema.php';

		$res  = $this->client->get($link, $params);
		$html = $res->getBody()->getContents();

		$crawler = new Crawler(null, null, self::BASE_HREF);
		$crawler->addHtmlContent($html, 'windows-1251');

		$year        = $poster = null;
		$description = $name = '';
		$posterNode  = $crawler->filterXPath('//table[7]//table[1]//td[5]/table[2]/tr/td[1]//table/tr/td/a/img');
		if ($posterNode->count()) {
			$poster = $posterNode->attr('src');
		}
		$nameNode = $crawler->filterXPath('//table[7]//table[1]//td[5]/table[2]/tr/td[4]/font');
		if ($nameNode->count()) {
			$name = $nameNode->text('src');
		}
		//$yearNode            = $crawler->filterXPath('//table[7]//table[1]//td[5]/table[2]/tr/td[4]/table');
		$descriptionNode = $crawler->filter('p.review');

		if ($descriptionNode->count()) {
			$description = $descriptionNode->text();
		}

		return [
			'name'        => $name,
			'description' => $description,
			'poster'      => $poster,
			'year'        => $year
		];
	}

}