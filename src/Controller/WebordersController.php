<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebordersController extends AbstractController
{
    #[Route('/weborders', name: 'app_weborders')]
    public function index(): Response
    {
        return $this->render('weborders/index.html.twig', [
            'controller_name' => 'WebordersController',
        ]);
    }
}
