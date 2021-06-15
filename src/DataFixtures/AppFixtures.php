<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$category = new Category();
		$category->setName('Рейтинг западных сериалов');
		$category->setUrl('http://www.world-art.ru/cinema/rating_tv_top.php');
        $category->setPublicListAnchor(1);
		$manager->persist($category);

	    $category = new Category();
	    $category->setName('Рейтинг корейских дорам');
	    $category->setUrl('http://www.world-art.ru/cinema/rating_tv_top.php');
        $category->setPublicListAnchor(4);
	    $manager->persist($category);

	    $category = new Category();
	    $category->setName('Рейтинг российских сериалов');
	    $category->setUrl('http://www.world-art.ru/cinema/rating_tv_top.php');
        $category->setPublicListAnchor(3);
	    $manager->persist($category);

	    $category = new Category();
	    $category->setName('Рейтинг японских дорам');
	    $category->setUrl('http://www.world-art.ru/cinema/rating_tv_top.php');
        $category->setPublicListAnchor(2);
	    $manager->persist($category);

	    $category = new Category();
	    $category->setName('Рейтинг полнометражных фильмов');
	    $category->setUrl('http://www.world-art.ru/cinema/rating_top.php');
        $category->setPublicListAnchor(0);
	    $manager->persist($category);

		$manager->flush();
    }
}
