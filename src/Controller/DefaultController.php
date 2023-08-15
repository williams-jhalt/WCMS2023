<?php

namespace App\Controller;

use App\Message\ReloadFromErpMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/erp-reload', name: 'app_reload_from_erp')]
    public function reload(MessageBusInterface $bus): Response
    {

        $bus->dispatch(new ReloadFromErpMessage());

        return $this->redirect('/admin');

    }
}
