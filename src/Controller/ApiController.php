<?php

namespace App\Controller;

use App\Entity\Fruit;
use App\Entity\Nutrition;
use App\Repository\FruitRepository;
use App\Repository\NutritionRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/all', name: 'app_api_all')]
    public function index(ManagerRegistry $doctrine, FruitRepository $fruitRepository): Response
    {

        $fruits = $doctrine
            ->getRepository(Fruit::class)
            ->findAll();
  
        $data = [];
        return $this->json($fruits);
    }
    #[Route('/filter', name: 'app_api_filter',  methods: ['GET', 'POST'])]
    public function filter(Request $request, ManagerRegistry $doctrine, FruitRepository $fruitRepository): Response
    {
        $request_name = $request->query->get('fname');
        $request_family = $request->query->get('family');
        $request_num_id = $request->query->get('numid');

        $fruits = $doctrine
            ->getRepository(Fruit::class)->findfruit($request_name, $request_family);
        if($fruits) {
            $nutrition = $doctrine
            ->getRepository(Nutrition::class)->findnutrition(array_values((Array)$fruits[0])[3]);
        } else {
            $nutrition = null;
        }
        
         $data = ["fruit"=> $fruits, "nutrition"=>$nutrition];
  
         return $this->json($data);
    }
    
}
