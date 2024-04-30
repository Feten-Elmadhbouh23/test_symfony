<?php


namespace App\Controller;

use App\Entity\CommandeResto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $commandes = $this->entityManager->getRepository(CommandeResto::class)->findAll(); // Correction ici

        return $this->render('livreur/commendeliv/commendeclient.html.twig', [
            'commandes' => $commandes,
        ]);
    }
    #[Route('/commendeliv/{id}/supprimer', name: 'app_supprimer_commande', methods: ['POST'])]
    public function supprimerCommande(CommandeResto $commande, Request $request): RedirectResponse
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $submittedToken)) {
            $this->entityManager->remove($commande);
            $this->entityManager->flush();
            $this->addFlash('success', 'La commande a été supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide. La commande n\'a pas été supprimée.');
        }

        return $this->redirectToRoute('app_liste');
    }
}
