<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @var CategoriesRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CategoriesController constructor.
     */
    public function __construct(CategoriesRepository $repository, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/new", methods="POST", name="admin_categorie_new")
     */
    public function addCategorie(Request $request): Response
    {
        $categorie = new Categorie();
        $categories = $this->repository->findAll();

        $form = $this->createFormBuilder($categorie)
            ->add('title', TextType::class)
            ->add('slug', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Categorie'])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($categorie);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_categorie_index');
        }

        return $this->render('admin/blog/new_categories.twig', [
            'countCategories' => count($categories),
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }
}
