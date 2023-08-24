<?php

namespace App\Controller;

use App\Entity\Weborder;
use App\Repository\WeborderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

    #[Route('/weborders/new', name: 'app_weborders_new')]
    public function newOrder(Request $request, EntityManagerInterface $em): Response
    {

        $weborder = new Weborder();

        $form = $this->createFormBuilder($weborder)
            ->add('reference1', TextType::class)
            ->add('reference2', TextType::class)
            ->add('shipToName', TextType::class)
            ->add('shipToAddress', TextType::class)
            ->add('shipToAddress2', TextType::class)
            ->add('shipToAddress3', TextType::class)
            ->add('shipToCity', TextType::class)
            ->add('shipToState', TextType::class)
            ->add('shipToZip', TextType::class)
            ->add('shipToCountry', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit Order'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $weborder = $form->getData();
            $em->persist($weborder);
            $em->flush();

            return $this->redirectToRoute('app_weborders');
        }

        return $this->render('weborders/new.html.twig', [
            'form' => $form
        ]);

    }
}