<?php

namespace App\Command;
use Psr\Log\LoggerInterface;

use App\Entity\Fruit;
use App\Entity\Nutrition;
use App\Repository\FruitRepository;
use App\Repository\NutritionRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(name: 'fruits:fetch')]
class FruitsCommand extends Command
{
    private $doctrine;
    public function __construct(
        ManagerRegistry $doctrine
    ) {
        // you *must* call the parent constructor
        parent::__construct();
       $this->doctrine = $doctrine;
        
    }
    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        // Use in-build functions to set name, description and help

        $this->setDescription('This command fetch the fruits api data');
    }
    protected function apicall() {
       
        
    }
    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('updating database from the fruit api link.....');

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://fruityvice.com/api/fruit/all');

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        $entityManager = $this->doctrine->getManager();
        $entities  = $entityManager->getRepository(Fruit::class)->findall();
        foreach ($entities as $entity) {
            $entityManager->remove($entity);
        }
        $entityManager->flush();
        
        $entityManager = $this->doctrine->getManager();
        $entities  = $entityManager->getRepository(Nutrition::class)->findall();
        foreach ($entities as $entity) {
            $entityManager->remove($entity);
        }
        $entityManager->flush();

        foreach($content as $value) {
            $entityManager = $this->doctrine->getManager();
            $fruit = new Fruit();
            $entityManager->remove($fruit);

            $fruit->setGenus($value['genus']);
            $fruit->setName($value['name']);
            $fruit->setNumid($value['id']);
            $fruit->setFamily($value['family']);
            $fruit->setForder($value['order']);
            $entityManager->persist($fruit);
            $entityManager->flush();

            $entityManager = $this->doctrine->getManager();
            $nutrition = new Nutrition();
            $nutrition->setCarbohydrates($value['nutritions']['carbohydrates']);
            $nutrition->setProtein($value['nutritions']['protein']);
            $nutrition->setFat($value['nutritions']['fat']);
            $nutrition->setCalories($value['nutritions']['calories']);
            $nutrition->setSugar($value['nutritions']['sugar']);
            $nutrition->setNumid($value['id']);
            $entityManager->persist($nutrition);
            $entityManager->flush();
        }
        $output->writeln('Saved the data to the database successfully!');
        // Return below values according to the occurred situation
        return Command::SUCCESS;     
    }

    
}