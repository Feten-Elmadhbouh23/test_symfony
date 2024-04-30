<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\CommandeResto;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twilio\Rest\Client as TwilioClient;
class LivraisonController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/livraison/{clientId}', name: 'app_livraison')]
    public function livraison($clientId, MailerInterface $mailer): Response
    {
        $clientRepository = $this->entityManager->getRepository(Client::class);
        $vehiculeRepository = $this->entityManager->getRepository(Vehicule::class);

        $client = $clientRepository->find($clientId);
        $dernierVehicule = $vehiculeRepository->findOneBy([], ['id' => 'DESC']);
        $derniereCommande = $this->entityManager->getRepository(CommandeResto::class)->findOneBy(
            ['idClient' => $clientId],
            ['dateCreation' => 'DESC']
        );

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        if (!$derniereCommande) {
            throw $this->createNotFoundException('Aucune commande trouvée pour ce client');
        }
        return $this->render('livreur/livraison/livraison.html.twig', [
            'clientDetails' => $client,
            'dernierVehicule' => $dernierVehicule,
            'derniereCommande' => $derniereCommande,
        ]);
    }
}
