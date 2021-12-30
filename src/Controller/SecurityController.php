<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\Client;
use App\Entity\Magasinier;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController 
{
    /**
    * @param string $role
    * @param Request $request
    * @return Response
    * @Route("/registration", name="security_registration")
    */

    public function registration(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response 
    {
        $utilisateur = new Client();
        $utilisateur->setUserType(1);

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(RegistrationType::class, $utilisateur)->handlerequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hashedPassword = $passwordHasher->hashPassword($utilisateur,$utilisateur->getPPassword());
            $utilisateur->setMdp($hashedPassword);
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash("succes","votre inscription a été réalisé avec succès"); 
            return $this->redirectToRoute("index");


        }

        return $this->render("interface/security/registration.html.twig", ["form" => $form->createView()]);

    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render("interface/security/login.html.twig", [
            "last_username" => $authenticationUtils->getLastUsername(),
            "error" => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
    }


   
}
