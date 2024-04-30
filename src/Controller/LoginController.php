<?php

namespace App\Controller;

use App\Entity\Livreur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class LoginController extends AbstractController
{

    
    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/check_login', name: 'check_login', methods: ['POST'])]
    public function checkLogin(Request $request): Response
    {
        $email = $request->request->get('_username');
        $password = $request->request->get('_password');

        $livreurRepository = $this->entityManager->getRepository(Livreur::class);
        $livreur = $livreurRepository->findOneBy(['email' => $email]);

        if (!$livreur || !$this->passwordEncoder->isPasswordValid($livreur, $password)) {
            $this->addFlash('error', 'Adresse email ou mot de passe incorrect');
            return $this->redirectToRoute('app_login');
        }

        // Sécurité améliorée: Authentifier l'utilisateur
        // $this->get('security.token_storage')->setToken(new UsernamePasswordToken($livreur, null, 'main', $livreur->getRoles()));
        // Redirection sécurisée vers la page d'accueil
        return $this->redirectToRoute('page_admin');
    }
}
