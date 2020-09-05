<?php

namespace App\Controller;

use App\Entity\FocusVille;
use App\Form\FocusVilleType;
use App\Repository\FocusVilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FocusVilleController extends AbstractController
{
    /**
     * @Route("/focus_ville", name="focus_ville")
     */
    public function index(FocusVilleRepository $repo)
    {
        $focus= $repo->findAll();

        return $this->render('focus_ville/index.html.twig', [
            'focus' => $focus
        ]);
    }
    
    /**
     * Permet de créer un Focus Ville
     *
     * @Route("/ads/new_ville", name="ads_ville")
     * 
    * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager) {

        $focus_ville = new FocusVille();

        $form = $this->createForm(FocusVilleType::class, $focus_ville);
        $form->handleRequest($request);

        //On fait appel au manager avec EntityMangerInterface pour pouvoir l'utiliser
        //Rappel le manager c'est lui qui gere l'enregistrement des données en BDD

        //Avec ce If on verfifie si le form est soumit et valid avant de le faire persister en BDD
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($focus_ville);
            $manager->flush();
            
            return $this->redirectToRoute('focus_show_ville', [
                'slug' => $focus_ville->getSlug()
            ]);
        }


        return $this->render('focus_ville/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * Permet d'éditer un focus ville
     * 
     * @Route("/focus_ville/{slug}/edit", name="ville_edit")
     * 
     * @return Response
     */
    public function edit(FocusVille $focus_ville, Request $request, EntityManagerInterface $manager) {

        $form = $this->createForm(FocusVilleType::class, $focus_ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($focus_ville);
            $manager->flush();
            
            return $this->redirectToRoute('focus_show_ville', [
                'slug' => $focus_ville->getSlug()
            ]);
        }

        return $this->render('focus_ville/edit.html.twig', [
            'form' => $form->createView(),
            'focus_ville' => $focus_ville
        ]);
    }


    /**
     * Permet d'afficher une seul annonce
     *
     * @Route("/focus_ville/{slug}", name="focus_show_ville")
     * 
     * @return Response
     */
    public function show(FocusVille $focus){
        return $this->render('focus_ville/show.html.twig', [
            'focus' => $focus,
        ]);
    }
}
