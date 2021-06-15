<?php


namespace App\Command;


use App\Entity\Category;
use App\Service\MoviesManager;
use App\Service\WordArtParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParsCommand extends Command
{
    protected static $defaultName = 'app:pars';
    private $parser;
    private $em;
    private $moviesManager;

    public function __construct(WordArtParser $wordArtParser, EntityManagerInterface $entityManager, MoviesManager $moviesManager)
    {
        $this->em = $entityManager;
        $this->moviesManager = $moviesManager;
        $this->parser = $wordArtParser;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categories = $this->em->getRepository(Category::class)->findAll();
        foreach ($categories as $category){

            $data = $this->parser->parseAllCinemaByCategories($category);
            $output->writeln('Parsed '.$category->getUrl());
            $this->moviesManager->saveListMovies($data);
            $output->writeln('Saved '.$category->getUrl());
        }
        $output->writeln('Movies successfully parsed!');

        return Command::SUCCESS;
    }
}