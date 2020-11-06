<?php

namespace App\Controller;

use App\Entity\FocusPays;
use App\Form\FocusPaysType;
use App\Repository\FocusPaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPaysController extends AbstractController
{
    /**
     * @Route("/admin/pays", name="admin_pays_index")
     */
    public function index(FocusPaysRepository $repo)
    {
        return $this->render('admin/focus_pays/index.html.twig', [
            'focus_pays' => $repo->findAll()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/admin/pays/{id}/edit", name="admin_focuspays_edit")
     * 
     * @param FocusPays $focuspays
     * @return Response
     */
    public function edit(FocusPays $focuspays, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(FocusPaysType::class, $focuspays);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($focuspays);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$focuspays->getTitle()} a bien été enregistrée !"
            );
        }

        return $this->render('admin/focus_pays/edit.html.twig', [
            'focuspays' => $focuspays,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     *
     * @Route("/admin/pays/{id}/delete", name="admin_focuspays_delete")
     * 
     * @param FocusPays $focuspays
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(FocusPays $focuspays, EntityManagerInterface $manager) {
        
        $manager->remove($focuspays);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$focuspays->getTitle()}</strong> a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_pays_index');
    }
}
