<?php
namespace App\Controller;

use App\Entity\ZoneLiv;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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

        return $this->render('zone/zone.html.twig', [
            'zones' => $zones,
        ]);
    }

    #[Route('/ajouter_zone', name: 'ajouter_zone')]
    public function ajouterZone(Request $request): Response
    {
        // Récupérer le nom de la zone à partir de la requête
        $nouvelleZone = $request->request->get('zone');

        // Créer une nouvelle instance de l'entité ZoneLiv
        $zone = new ZoneLiv();
        $zone->setZone($nouvelleZone);

        // Ajouter la nouvelle zone à la base de données
        $this->entityManager->persist($zone);
        $this->entityManager->flush();

        // Rediriger vers la page des zones avec un message de succès
        $this->addFlash('success', 'La zone a été ajoutée avec succès.');

        return $this->redirectToRoute('app_zone');
    }
}
