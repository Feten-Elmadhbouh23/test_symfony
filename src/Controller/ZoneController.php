<?php

namespace App\Controller;

use App\Entity\ZoneLiv;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ZoneController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/zone', name: 'app_zone')]
    public function index(): Response
    {
        $zones = $this->entityManager->getRepository(ZoneLiv::class)->findAll();
        $clients = $this->entityManager->getRepository(Client::class)->findAll();

        return $this->render('/livreur/zone/zone.html.twig', [
            'zones' => $zones,
            'clients' => $clients,
        ]);
    }

    #[Route('/zone/new', name: 'app_zone_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $zone = new ZoneLiv();
        $form = $this->createForm(ZoneLiv::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($zone);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_zone');
        }

        return $this->render('zone/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/zone/{id}/edit', name: 'app_zone_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ZoneLiv $zone): Response
    {
        // Créez le formulaire pour éditer la zone de livraison

        $form = $this->createForm(ZoneLiv::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_zone');
        }

        return $this->render('zone/edit.html.twig', [
            'zone' => $zone,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/zone/{id}', name: 'app_zone_delete', methods: ['DELETE'])]
    public function delete(Request $request, ZoneLiv $zone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zone->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($zone);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_zone');
    }
#[Route('/zone/{zoneName}', name: 'clients_par_zone')]
public function clientsParZone(Request $request, $zoneName): JsonResponse
{
    // Correction de la recherche des clients par leur adresse
    $clients = $this->entityManager->getRepository(Client::class)->findBy(['adresse' => $zoneName]);

    return $this->json($clients);
}
}
