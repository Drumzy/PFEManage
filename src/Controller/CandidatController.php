<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CandidatController extends AbstractController
{
    /**
     * @Route("/new_candidat", name="candidat")
     */
    public function index(): Response
    {
        return $this->render('candidat/new.html.twig', [
            'controller_name' => 'CandidatController',
        ]);
    }

    /**
     * @Route("/candidat/new", name="new_candidat")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $candidat = new Candidat();
      
        $form = $this->createForm(CandidatType::class,$candidat);

        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $candidat = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($candidat);
          $entityManager->flush();
  
          return $this->redirectToRoute('sujets');
        }
        return $this->render('candidat/listeSujets.html.twig',['form' => $form->createView()]);
    }
}
