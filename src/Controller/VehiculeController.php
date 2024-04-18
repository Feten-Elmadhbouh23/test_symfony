<?php

namespace App\Controller;

use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class VehiculeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/vehicule', name: 'app_vehicule')]
    public function index(EntityManagerInterface $entityManager): Response 
    { 
       
        $vehicules = $entityManager->getRepository(Vehicule::class)->findAll();

        return $this->render('vehicule/vehicule.html.twig', [
            'controller_name' => 'VehiculeController',
            'vehicules' => $vehicules,
        ]);
    }
    #[Route('/ajouter_vehicule', name: 'app_ajouter_vehicule', methods: ['POST'])]
    public function ajouterVehicule(Request $request): Response
    {
        $type = $request->request->get('type');
    
     
        if (empty($type)) {
            return new Response('Le champ type ne peut pas être vide.', Response::HTTP_BAD_REQUEST);
        }
    
        $existingVehicule = $this->entityManager->getRepository(Vehicule::class)->findOneBy(['type' => $type]);
        if ($existingVehicule) {
            return new Response('Ce type de véhicule existe déjà.', Response::HTTP_BAD_REQUEST);
        }
    
        $typesAutorises = ["scooter", "velo", "Moto", "fourgon", "voiture"];
        if (!in_array($type, $typesAutorises)) {
            return new Response('Le type de véhicule n\'est pas valide.', Response::HTTP_BAD_REQUEST);
        }
    
        $vehicule = new Vehicule();
        $vehicule->setType($type);
        $this->entityManager->persist($vehicule);
        $this->entityManager->flush();
    
        return $this->redirectToRoute('app_vehicule');
    }
    #[Route('/modifier-vehicule/{id}', name: 'modifier_vehicule')]
    public function modifierVehicule(Request $request, $id): Response
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            
            $nouveauType = $data['new_type'];
            
            if (empty($nouveauType)) {
                return new Response('Le champ type ne peut pas être vide.', Response::HTTP_BAD_REQUEST);
            }
            
            $vehicule = $this->entityManager->getRepository(Vehicule::class)->find($id);
            
            if (!$vehicule) {
                return new JsonResponse(['error' => 'Véhicule non trouvé pour l\'ID '.$id], JsonResponse::HTTP_NOT_FOUND);
            }
    
            
            $existingVehicule = $this->entityManager->getRepository(Vehicule::class)->findOneBy(['type' => $nouveauType]);
            if ($existingVehicule && $existingVehicule->getId() != $id) {
                return new Response('Ce type de véhicule existe déjà.', Response::HTTP_BAD_REQUEST);
            }
    
            
            $typesAutorises = ["scooter", "velo", "Moto", "fourgon", "voiture"];
            if (!in_array($nouveauType, $typesAutorises)) {
                return new Response('Le type de véhicule n\'est pas valide.', Response::HTTP_BAD_REQUEST);
            }
    
            $vehicule->setType($nouveauType);
            $this->entityManager->flush();
    
            return new JsonResponse(['success' => true]);
        }
    
        return new JsonResponse(['error' => 'Cette route doit être utilisée avec une requête AJAX.'], JsonResponse::HTTP_METHOD_NOT_ALLOWED);
    }
    
  

    #[Route('/supprimer-vehicule/{id}', name: 'supprimer_vehicule')]
    public function supprimerVehicule($id): Response
    {
        $vehicule = $this->entityManager->getRepository(Vehicule::class)->find($id);

        if (!$vehicule) {
            throw $this->createNotFoundException('Véhicule non trouvé pour l\'ID '.$id);
        }

        $this->entityManager->remove($vehicule);
        $this->entityManager->flush();

        $this->addFlash('success', 'Véhicule supprimé avec succès.');
        return $this->redirectToRoute('app_vehicule');
    }
}
