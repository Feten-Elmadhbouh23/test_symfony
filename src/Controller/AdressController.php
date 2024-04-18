<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/clients-par-zone/{zoneId}", name="clients_par_zone", methods={"GET"})
     */
    public function getClientsByZone(Request $request, $zoneId): JsonResponse
    {
        $clients = $this->entityManager->getRepository(Client::class)->findBy(['zone' => $zoneId], ['id' => 'ASC']);
        
        $formattedClients = [];
        foreach ($clients as $client) {
            $formattedClients[] = [
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'email' => $client->getEmail(),
                'adresse' => $client->getAdresse(),
                'numTel' => $client->getNumTel(),
                'date' => $client->getDate()->format('Y-m-d H:i:s')
            ];
        }

        return new JsonResponse($formattedClients);
    }
}

