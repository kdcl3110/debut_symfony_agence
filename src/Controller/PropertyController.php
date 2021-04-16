<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property.index")
     */
    public function index(EntityManagerInterface $manager, PropertyRepository $repo): Response
    {
        $property = $repo->findAllVisible();
        $property[0]->setSold(false);
        $manager->flush();

        return $this->render('property/index.html.twig', [
            'controller_name' => 'properties',
        ]);
    }
}
