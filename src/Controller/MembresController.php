<?php

namespace App\Controller;

use App\Entity\Membres;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembresController extends AbstractController
{   
    #[Route('/membres/ajout', name:'add_membres')]
    #[Route('/membres', name: 'app_membres')]

    public function add( Request $request, EntityManagerInterface $em)
    {
        $membres = new Membres;
        $form= $this->createForm(FormType::class, $membres );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $membres->setDateEnregistrement(new \DateTime());
            $em->persist($membres);
            $em->flush();

            //Achanger le tableau peut etre
            return $this->redirectToRoute('app_membres');
        }
        
        return $this->render('membres/membres.html.twig', [
            'formmembre' => $form
        ]);
    }
    public function index(): Response
    {
        return $this->render('membres/membres.html.twig');
    }


}
