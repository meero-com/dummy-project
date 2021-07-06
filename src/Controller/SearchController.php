<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search", name="app_search", methods={"GET"})
 */
class SearchController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(Request $request): Response
    {
        $searchOn = $request->query->get('searchOn', 'all');
        $searchTerm = $request->query->get('searchTerm');
        $searchCategory = $request->query->get('searchCategory');

        $qb = $this->postRepository->createQueryBuilder('p');

        if ($searchOn === 'title') {
            $qb->andWhere('p.title LIKE %'.$searchTerm.'%');
        }

        if ($searchOn === 'description') {
            $qb->andWhere('p.description LIKE %'.$searchTerm.'%');
        }

        if ($searchOn === 'all') {
            $qb->andWhere('p.description LIKE %'.$searchTerm.'% OR title LIKE %'.$searchTerm.'%');
        }

        if ($searchCategory === 'news') {
            $qb->andWhere('p.categorie = '.$searchCategory)
                ->orderBy('p.publishedAt',  'ASC');
        }

        if ($searchCategory === 'tutorial') {
            $qb->andWhere('p.categorie = '.$searchCategory)
                ->orderBy('p.publishedAt',  'DESC')
            ;
        }

        $posts = $qb->getQuery()->getResult();

        $this->render('seach.html.twig', [
            'posts' => $posts,
        ]);
    }
}
