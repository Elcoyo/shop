<?php

namespace App\Controller;

use App\Entity\Produit;

use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/backoffice', name:'backoffice')]
    public function gestion()
    {
        return $this->render('main/backoffice.html.twig');
    }

    #[Route('/ajout', name: 'addform')]
    public function addform(Request $request, EntityManagerInterface $em)
    {
        $produit = new Produit;

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
        // $produit = $form->get('brochure')->getData();
        $produit->setDateEnregistrement(new \DateTime());
        $em->persist($produit);
        $em->flush();

        return $this->redirectToRoute('tableau_produit');

        }
        
        return $this->render('main/ajout.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/produit/tableau/', name:'tableau_produit')]
    public function table(ProduitRepository $repo,){
        $produit=$repo->findAll();
        return $this->render('main/gestion.html.twig', [
            'produit' => $produit
        ]);
    }
    #[Route('/produit/edit/{id}', name:'edit_produit')]
    public function edit(Request $request, EntityManagerInterface $manager, Produit $produit){
       
        $form= $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $produit= $form->getData();
            $manager->persist($produit);
            $manager->flush();
            
            return $this->redirectToRoute('tableau_produit');
        };
        
        return  $this->render('main/edit.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/produit/delete/{id}', name:'delete_produit')]
    public function delete(EntityManagerInterface $manager, Produit $produit){

        $manager->remove($produit);
        $manager->flush();
        return $this->redirectToRoute('tableau_produit');
    }

}
