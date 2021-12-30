<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;
use App\Repository\PanierRepository;
use App\Repository\CommandeRepository;
/**
 * Class PanierController
 * @package App\Controller
 * @Route("/panier")
 * @IsGRanted("ROLE_Client")
 */
class OrderController extends AbstractController
{
    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_TeamLeader")
     * @Route("/validate/{id}", name="cart_validate")
     */
    public function validate($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository){

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom'=>$id]);
        $order->setStateCom(2);
        $entityManager->flush();

        $this->addFlash("succes","la commande a bien été validé");
        return $this-> redirectToRoute("cart_team_carts");
    }

    /**
     * @return Response
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/process", name="cart_process")
     */
    public function process(ManagerRegistry $doctrine, Request $request, CommandeRepository $commandeRepository){

        $commandes_=[];
        $commandes=[];
            $commandes_ = $commandeRepository->findBy([],['stateCom' =>'ASC']);
            foreach ($commandes_ as $id_) {
                if ($id_->getStateCom() > 1)
                    array_push($commandes,$id_);
            }


        return $this->render("interface/cart/cartsToProcess.html.twig", [
            "commandes" => $commandes
        ]);
    }
    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/deliver/{id}", name="cart_deliver")
     */
    public function deliver($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository){

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom'=>$id]);
        $order->setStateCom(3);
        $entityManager->flush();

        $this->addFlash("succes","la commande a bien été traité");
        return $this-> redirectToRoute("cart_process");
    }
    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/delivered/{id}", name="cart_delivered")
     */
    public function delivered($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository){

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom'=>$id]);
        $order->setStateCom(4);
        $entityManager->flush();

        $this->addFlash("succes","La commande a bien été livré");
        return $this-> redirectToRoute("cart_process");
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/cancel/{id}", name="cart_cancel")
     */
    public function cancel($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository){

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom'=>$id]);
        $order->setStateCom(5);
        $entityManager->flush();

        $this->addFlash("succes","La commande a bien été annulé");
        return $this-> redirectToRoute("cart_process");
    }


}





