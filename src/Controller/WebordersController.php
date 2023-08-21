<?php

namespace App\Controller;

use App\Repository\WeborderRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebordersController extends AbstractController
{
    #[Route('/weborders', name: 'app_weborders')]
    public function index(Request $request, WeborderRepository $repo): Response
    {

        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 25);

        $qb = $repo->createQueryBuilder('o');

        $adapter = new QueryAdapter($qb);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $page, $perPage);

        return $this->render('weborders/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }
}
