<?php

namespace App\Controller;

use App\Entity\FocusPays;
use App\Entity\FocusVille;
use App\Form\FocusPaysType;
use App\Repository\FocusPaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FocusPaysController extends AbstractController
{
    /**
     * @Route("/focus_pays", name="focus_pays")
     */
    public function index(FocusPaysRepository $repo)
    {
        $focus= $repo->findAll();

        return $this->render('focus_pays/index.html.twig', [
            'focus' => $focus
        ]);
    }
    
    /**
     * Permet de créer un Focus Pays
     *
     * @Route("/ads/new_pays", name="ads_pays")
     * 
    * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager) {

        $focus_pays = new FocusPays();

        $form = $this->createForm(FocusPaysType::class, $focus_pays);

        $form->handleRequest($request);

        //On fait appel au manager avec EntityMangerInterface pour pouvoir l'utiliser
        //Rappel le manager c'est lui qui gere l'enregistrement des données en BDD

        //Avec ce If on verfifie si le form est soumit et valid avant de le faire persister en BDD
        if($form->isSubmitted() && $form->isValid()){

            $focus_pays->setAuthor($this->getUser());

            $manager->persist($focus_pays);
            $manager->flush();

            return $this->redirectToRoute('focus_show_pays', [
                'slug' => $focus_pays->getSlug()
            ]);
        }

        return $this->render('focus_pays/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'éditer une annonce
     * 
     * @Route("/focus_pays/{slug}/edit", name="pays_edit")
     * 
     * @return Response
     */
    public function edit(FocusPays $focus_pays, Request $request, EntityManagerInterface $manager) {

        $form = $this->createForm(FocusPaysType::class, $focus_pays);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($focus_pays);
            $manager->flush();

            return $this->redirectToRoute('focus_show_pays', [
                'slug' => $focus_pays->getSlug()
            ]);
        }

        return $this->render('focus_pays/edit.html.twig', [
            'form' => $form->createView(),
            'focus_pays' => $focus_pays
        ]);
    }

    /**
     * Permet d'afficher un focus pays
     *
     * @Route("/focus_pays/{slug}", name="focus_show_pays")
     * 
     * @return Response
     */
    public function show(FocusPays $focus){
        return $this->render('focus_pays/show.html.twig', [
            'focus' => $focus,
        ]);
    }
}
