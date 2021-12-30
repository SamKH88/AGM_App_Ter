<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProductType;
use App\Form\ProductUpdateType;
use App\Form\RegistrationType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 * @Route("/products")
 * @IsGranted("ROLE_Client")
 */
class ProductController extends AbstractController
{
    /**
     * @param ProduitRepository $productRepository
     * @return Response
     * @Route("/", name="product_index")
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render("interface/produit/index.html.twig", [
            "products" => $produitRepository->findAll()
        ]);
    }

     /**
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_Magasinier")
     * @Route("/create", name="product_create")
     */
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $product = new Produit();

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(ProductType::class, $product)->handlerequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash("success","Le produit a bien été ajouté ");
            return $this->redirectToRoute("product_create");


        }

        return $this->render("interface/produit/create.html.twig", ["form" => $form->createView()]);

    }

    /**
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_Magasinier")
     * @Route("/update/{id}", name="product_update")
     */
    public function update($id, Request $request, ManagerRegistry $doctrine): Response
    {

        $product = new Produit();
        $entityManager = $doctrine->getManager();
        $product_ = $entityManager->getRepository(Produit::class)->find($id);

        $form = $this->createForm(ProductUpdateType::class, $product)->handlerequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($product->getQteSt()!=null)
            $product_->setQteSt($product->getQteSt());
            if($product->getDateFin()!=null)
            $product_->setDateFin($product->getDateFin());
            $entityManager->flush();
            $this->addFlash("success","Le produit a bien été mis à jour ");
            return $this->redirectToRoute("product_index");


        }

        return $this->render("interface/produit/update.html.twig", ["form" => $form->createView()]);

    }


    
}
