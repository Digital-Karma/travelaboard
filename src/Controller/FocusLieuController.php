<?php

namespace App\Controller;

use App\Entity\FocusLieu;
use App\Form\FocusLieuType;
use App\Repository\FocusLieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FocusLieuController extends AbstractController
{
    /**
     * @Route("/focus_lieu", name="focus_lieu")
     */
    public function index(FocusLieuRepository $repo)
    {
        $focus= $repo->findAll();

        return $this->render('focus_lieu/index.html.twig', [
            'focus' => $focus
        ]);
    }
    
    /**
     * Permet de créer un Focus Lieu
     *
     * @Route("/ads/new_lieu", name="ads_lieu")
     * 
    * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager) {

        $focus_lieu = new FocusLieu();

        $form = $this->createForm(FocusLieuType::class, $focus_lieu);

        $form->handleRequest($request);

        //On fait appel au manager avec EntityMangerInterface pour pouvoir l'utiliser
        //Rappel le manager c'est lui qui gere l'enregistrement des données en BDD

        //Avec ce If on verfifie si le form est soumit et valid avant de le faire persister en BDD
        if($form->isSubmitted() && $form->isValid()){

            $focus_lieu->setAuthor($this->getUser());

            $manager->persist($focus_lieu);
            $manager->flush();

            return $this->redirectToRoute('focus_show_lieu', [
                'slug' => $focus_lieu->getSlug()
            ]);
        }


        return $this->render('focus_lieu/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'éditer un focus lieu
     * 
     * @Route("/focus_lieu/{slug}/edit", name="lieu_edit")
     * 
     * @return Response
     */
    public function edit(FocusLieu $focus_lieu, Request $request, EntityManagerInterface $manager) {

        $form = $this->createForm(FocusLieuType::class, $focus_lieu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($focus_lieu);
            $manager->flush();

            return $this->redirectToRoute('focus_show_lieu', [
                'slug' => $focus_lieu->getSlug()
            ]);
        }

        return $this->render('focus_lieu/edit.html.twig', [
            'form' => $form->createView(),
            'focus_lieu' => $focus_lieu
        ]);
    }


    /**
     * Permet d'afficher une seul annonce
     *
     * @Route("/focus_lieu/{slug}", name="focus_show_lieu")
     * 
     * @return Response
     */
    public function show(FocusLieu $focus){
            return $this->render('focus_lieu/show.html.twig', [
            'focus' => $focus,
        ]);
    }
}
