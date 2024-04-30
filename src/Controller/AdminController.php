<?php

namespace App\Controller;

use App\Entity\Livreur;
use Doctrine\ORM\EntityManagerInterface; // Importer EntityManagerInterface
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $entityManager;

    // Injecter l'EntityManagerInterface dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        // Récupérer la liste des livreurs depuis la base de données
        $livreurs = $this->entityManager->getRepository(Livreur::class)->findAll();

        // Rendre le template Twig en passant la liste des livreurs comme paramètre
        return $this->render('admin/adminliv.html.twig', [
            'controller_name' => 'AdminController',
            'livreurs' => $livreurs, // Passer la liste des livreurs au template Twig
        ]);
    }
}
