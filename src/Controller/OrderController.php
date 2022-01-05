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
    public function validate($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository)
    {

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom' => $id]);
        $order->setStateCom(2);
        $entityManager->flush();

        $this->addFlash("succes", "la commande a bien été validé");
        return $this->redirectToRoute("cart_team_carts");
    }

    /**
     * @return Response
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/process", name="cart_process")
     */
    public function process(ManagerRegistry $doctrine, Request $request, CommandeRepository $commandeRepository)
    {

        $commandes_ = [];
        $commandes = [];
        $commandes_ = $commandeRepository->findBy([], ['stateCom' => 'ASC']);
        foreach ($commandes_ as $id_) {
            if ($id_->getStateCom() > 1)
                array_push($commandes, $id_);
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
    public function deliver($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository)
    {

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom' => $id]);
        $order->setStateCom(3);
        $entityManager->flush();

        $this->addFlash("succes", "la commande a bien été traité");
        return $this->redirectToRoute("cart_process");
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/delivered/{id}", name="cart_delivered")
     */
    public function delivered($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository, ProduitRepository $produitRepository)
    {

        $entityManager = $doctrine->getManager();
        $entityManager_ = $doctrine->getManager();
        $panier = $panierRepository->findBy(['numCom' => $id]);
        $order = $entityManager_->getRepository(Commande::class)->findOneBy(['numCom' => $id]);
        $success=0;
        foreach ($panier as $id_)
        {
            if($produitRepository->findOneBy(['refPro'=>$id_->getRefPro()])->getQteSt() >= $id_->getQtePro()){

                $produit = $entityManager->getRepository(produit::class)->findOneBy(['refPro' => $id_->getRefPro()]);
                $produit->setQteSt($produit->getQteSt() - $id_->getQtePro());
            }
            else{
                $success=1;
            }
        }
        if( $order->getStateCom()!=3)
            $success=2;

        if($success ==0)
        {
            $entityManager->flush();
            $order->setStateCom(4);
            $entityManager_->flush();
            $this->addFlash("succes", "La commande a bien été livré");
        }
        elseif ($success ==1) {
            $this->addFlash("failure", "Stock insuffisant pour satisfaire la commande");
        }
        else{
            $this->addFlash("failure", "Cette commande n'est pas en cours de traitement");
        }


        return $this->redirectToRoute("cart_process");
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/cancel/{id}", name="cart_cancel")
     */
    public function cancel($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository)
    {

        $entityManager = $doctrine->getManager();
        $order = $entityManager->getRepository(Commande::class)->findOneBy(['numCom' => $id]);
        $order->setStateCom(5);
        $entityManager->flush();

        $this->addFlash("succes", "La commande a bien été annulé");
        return $this->redirectToRoute("cart_process");
    }


    /**
     * @param $id
     * @return RedirectResponse
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/details/{id}", name="order_details")
     */
    public function details($id, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository, UtilisateurRepository $utilisateurRepository)
    {

        $session = $request->getSession();


        $produits = $panierRepository->findBy(['numCom' => $id]);
        $user = $utilisateurRepository->findOneBy(['userId' => $commandeRepository->findOneBy(['numCom' => $id])->getUserId()]);

        $paniers = [];
        $paniers[0] = $user;

        foreach ($produits as $id_) {
            $produit = $id_->getRefPro();
            $paniers[$produit] = $id_;
        }

        $session->set('panier', $paniers);
        return $this->redirectToRoute("order_display");

    }

    /**
     * @param Request $request
     * @return Response
     * @IsGRanted("ROLE_Magasinier")
     * @Route("/display", name="order_display")
     */
    public function display(Request $request, ProduitRepository $produitRepository): Response
    {

        $session = $request->getSession();
        $panier = $session->get('panier',[]);


        $panierComplet = [];
        $panierComplet[0]=$panier[0];


        foreach($panier as $id => $quantity) {
            if ($id != 0) {
                $panierComplet[] = [
                    'produit' => $id,
                    'qtePro' => $quantity->getQtePro()
                ];
            }

        }

        return $this->render('interface/cart/cartDetails.html.twig', ['items'=> $panierComplet] );

    }


}






