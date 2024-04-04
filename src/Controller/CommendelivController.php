<?php

// src/Controller/CommendelivController.php

namespace App\Controller;
use App\Entity\CommandeClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommendelivController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commendeliv', name: 'app_liste')]
    public function index(): Response
    {
        $commandes = $this->entityManager->getRepository(CommandeClient::class)->findAll();

        return $this->render('commendeliv/commendeclient.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}