<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Form\SujetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SujetController extends AbstractController
{
    /**
     * @Route("/sujets", name="sujets")
     */
    public function index(): Response
    {
        $sujets = $this->getDoctrine()->getRepository(Sujet::class)->findAll();
        return $this->render('candidat/listeSujets.html.twig', [
            'controller_name' => 'SujetController',
            'sujets' => $sujets,
        ]);
    }

    /**
     * @Route("/sujet/new", name="new_sujet")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $sujet = new Sujet();
      
        $form = $this->createForm(SujetType::class,$sujet);

        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $sujet = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($sujet);
          $entityManager->flush();
  
          return $this->redirectToRoute('sujets');
        }
        return $this->render('candidat/listeSujets.html.twig',['form' => $form->createView()]);
    }
}
