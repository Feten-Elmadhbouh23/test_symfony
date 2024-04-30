<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
class LivreurController extends AbstractController
{
    #[Route('/livreur', name: 'app_livreur')]
    public function index(): Response
    {
        return $this->render('livreur/livreur.html.twig', [
            'controller_name' => 'LivreurController',
        ]);
    }
    #[Route('/consulter-livreur/{id}', name: 'consulter_livreur')]
    public function consulterLivreur(int $id): Response
    {
        

        return $this->render('/livreur/livraison/livraison.html.twig', [
            'livreur_id' => $id,
            // Autres données du livreur à passer au template...
        ]);
    }
   
    #[Route('/livreur/position', name: 'livreur_position')]
    public function getPosition(): JsonResponse
    {
        // Géocoder l'adresse "ZI Choutrana 2 - Pôle technologique Al" pour obtenir les coordonnées de latitude et de longitude
        $latitude = 36.8501; // Latitude géocodée de l'adresse
        $longitude = 10.2075; // Longitude géocodée de l'adresse

        return $this->json([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }



}
