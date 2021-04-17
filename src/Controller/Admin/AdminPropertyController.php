<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repo;

    /** 
     * @var EntityManagerInterface 
     */
    private $manager;

    public function __construct(PropertyRepository $repo, EntityManagerInterface $manager)
    {
        $this->repo = $repo;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index(): Response
    {
        $properties = $this->repo->findAll();
        return $this->render("admin/property/index.html.twig", [
            "properties" => $properties
        ]);
    }

    /**
     * @Route("/admin/property/new", name="admin.property.new")
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="POST|GET")
     * @return Response
     */
    public function edit_create(Property $property = null, Request $request): Response
    {
        if (!$property) {
            $property = new Property();
        }

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($property);
            $this->manager->flush();
            $this->addFlash('success', 'opération éffectuée avec succes');

            return $this->redirectToRoute("admin.property.index");
        }

        return $this->render("admin/property/edit.html.twig", [
            "property" => $property,
            "form" => $form->createView(),
            'edit_mode' => $property->getId() !== null
        ]);
    }

    /**
     *@Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->manager->remove($property);
            $this->manager->flush();
            $this->addFlash('success', 'Bien supprimer avec succes');
        }

        return $this->redirectToRoute("admin.property.index");
    }
}
