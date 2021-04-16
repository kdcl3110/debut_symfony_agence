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
        return $this->render('property/index.html.twig', [
            'controller_name' => 'properties',
        ]);
    }
    /**
     * Undocumented function
     *@Route("biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     * @param [type] $property
     * @param [type] $slug
     * @return Response
     */
    public function show(Property $property, $slug, PropertyRepository $repo): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'controller_name' => 'properties',
            'property' => $property
        ]);
    }
}
