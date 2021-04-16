<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager, PropertyRepository $repo): Response
    {
        $properties = $repo->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties
        ]);
    }
}
