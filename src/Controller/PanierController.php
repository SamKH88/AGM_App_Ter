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
class PanierController extends AbstractController
{
    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/add/{id}", name="cart_add")
     */
    public function add($id, request $request): RedirectResponse
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) 
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1;
        }
        $session-> set('panier', $panier);

        $this->addFlash("succes","Le produit a bien été ajouté à votre paneir");
        return $this->redirectToRoute("product_index");

    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="cart_index")
     */
    public function index(Request $request, ProduitRepository $produitRepository): Response
    {

        $session = $request->getSession();
        $panier = $session->get('panier',[]);


        $panierComplet = [];

        foreach($panier as $id => $quantity) {
            
            $panierComplet[] = [
                'produit' =>  $produitRepository->find($id),
                'qtePro' => $quantity
            ];

        }

        return $this->render('interface/cart/index.html.twig', ['items'=> $panierComplet]);
        
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/remove/{id}", name="cart_remove")
     */
    public function remove($id, Request $request){
       
        $session = $request->getSession();
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this-> redirectToRoute("cart_index");

    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/increment/{id}", name="cart_increment")
     */
    public function increment($id, Request $request){

        $session = $request->getSession();
        $panier = $session->get('panier',[]);
        $panier[$id]++;

        $session->set('panier', $panier);

        return $this-> redirectToRoute("cart_index");

    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/decrement/{id}", name="cart_decrement")
     */
    public function decrement($id, Request $request){

        $session = $request->getSession();
        $panier = $session->get('panier',[]);

        if ($panier[$id]>0)
        $panier[$id]--;

        $session->set('panier', $panier);

        return $this-> redirectToRoute("cart_index");

    }


    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/submit", name="cart_submit")
     */
    public function submit(ManagerRegistry $doctrine, Request $request){

        $session = $request->getSession();
        $panier = $session->get('panier',[]);

        $entityManager = $doctrine->getManager();

        $commande = new Commande();

        $commande->setUserId($this->getUser()->getUserId());
        $commande->setDateCom(new \Datetime());
        $commande->setStateCom(1);

        $entityManager->persist($commande);
        $entityManager->flush();

        foreach($panier as $id => $quantity) {

        $ligne = new Panier();
        $ligne->setQtePro(intVal($quantity));
        $ligne->setNumCom($commande->getNumCom());
        $ligne->setNumCom($commande->getNumCom());
        $ligne->setrefPro($id);
            $entityManager->persist($ligne);
            $entityManager->flush();
        }

        $this->addFlash("succes","votre commande a bien été soumise");
        return $this-> redirectToRoute("cart_index");

    }


     /**
     * @param $id
     * @return RedirectResponse
     * @Route("/save", name="cart_save")
     */
    public function save(ManagerRegistry $doctrine, Request $request){

        $session = $request->getSession();
        $panier = $session->get('panier',[]);

        $entityManager = $doctrine->getManager();

        $commande = new Commande();

        $commande->setUserId($this->getUser()->getUserId());
        $commande->setDateCom(new \Datetime());

        $entityManager->persist($commande);
        $entityManager->flush();

        foreach($panier as $id => $quantity) {

            $ligne = new Panier();
            $ligne->setQtePro($quantity);
            $ligne->setNumCom($commande->getNumCom());
            $ligne->setrefPro($id);
            $entityManager->persist($ligne);
            $entityManager->flush();
        }

        $this->addFlash("succes","votre panier a bien été sauvegardé");
        return $this-> redirectToRoute("cart_index");

    }

    /**
    /**
     * @param ProduitRepository $productRepository
     * @return Response
     * @Route("/carts", name="cart_carts")
     */
    public function myCarts(CommandeRepository $commandeRepository, Request $request): response{

        $id = $this->getUser()->getUserId();
        return $this->render("interface/cart/myCarts.html.twig", [
            "commandes" => $commandeRepository->findBy(['userId' => $id, 'stateCom' => null])
        ]);

    }
    /**
     * @param $id
     * @return RedirectResponse
     * @Route("/load/{id}", name="cart_load")
     */
    public function load($id, Request $request, PanierRepository $panierRepository, ProduitRepository $produitRepository){

        $session = $request->getSession();


        $produits = $panierRepository->findBy(['numCom' => $id]);
        $paniers = [];
        foreach($produits as $id_) {
            $produit = $id_->getRefPro();
            $paniers[$produit] = $id_->getQtePro();


        }
        $session->set('panier', $paniers);
        $this->addFlash("succes","votre panier a bien été chargé");
        return $this-> redirectToRoute("cart_index");

    }


/**
 * @param $id
 * @return RedirectResponse
 * @Route("/delete/{id}", name="cart_delete")
 */
public function delete($id, ManagerRegistry $doctrine, Request $request, PanierRepository $panierRepository, CommandeRepository $commandeRepository){

    $entityManager = $doctrine->getManager();
    $commande = $commandeRepository->findOneBy(['numCom'=>$id]);
    $panier = $panierRepository->findBy(['numCom' => $id]);


    foreach($panier as $id_) {


        $entityManager->remove($id_);
        $entityManager->flush();
    }
    $entityManager->remove($commande);
    $entityManager->flush();

    $this->addFlash("succes","le panier a bien été supprimé");
    return $this-> redirectToRoute("cart_carts");

}

    /**
    /**
     * @param ProduitRepository $productRepository
     * @return Response
     * @Route("/teamcarts", name="cart_team_carts")
     */
    public function myTeamCarts(CommandeRepository $commandeRepository, Request $request, UtilisateurRepository $utilisateurRepository): response{

        $id = $this->getUser()->getTeam();
        $utilisateurs = $utilisateurRepository->findBy(['team' => $id]);
        $commandes=[];
        $commandes_=[];
        foreach($utilisateurs as $id){
            $commandes_ = $commandeRepository->findBy(['userId' => $id->getUserId() ], ['stateCom' => 'ASC']);
                foreach ($commandes_ as $id_) {
                    if ($id_->getStateCom() == 1 || $id_->getStateCom() == 2 ||$id_->getStateCom() == 3)
                    array_push($commandes,$id_);
                }

        }

        return $this->render("interface/cart/myTeamCarts.html.twig", [
            "commandes" => $commandes
        ]);

    }


}





