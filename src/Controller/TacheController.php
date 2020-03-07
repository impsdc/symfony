<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tache;
use App\Form\TacheFormType;
use Symfony\Component\HttpFoundation\Request;

class TacheController extends AbstractController
{
     /**
     * @Route("/tache", name="tache")
     */
    public function index(Request $request)
    {
        $pdo = $this->getDoctrine()->getManager();
        
        $tache = new Tache();
        $form = $this->createForm(TacheFormType::class, $tache);

        //analyse la requete HTTP
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //le form a été envoyé, on le sauvegarde
            $pdo->persist($tache); //prepare
            $pdo->flush() ;          //execute

            // rénitialisation du formulaire
            unset($entity);
            unset($form);
            $user = new Tache();
            $form = $this->createForm(TacheFormType::class, $tache);

            $this->addFlash("success", "Utilisateur ajouté !");
        }

        $allTaches = $pdo->getRepository(Tache::class)->findAll();
     
        return $this->render('tache/index.html.twig', [
            'tache' => $allTaches,
            'TacheForm' => $form->createView()
        ]);
    }

     /**
     * @Route("tache/{id}", name="tacheModif")
     */
    public function tacheModif(Request $request, Tache $tache=null){

        if($tache != null){
            $form = $this->createForm(TacheFormType::class, $tache);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                $pdo = $this->getDoctrine()->getManager();
                
                $pdo->persist($tache);
                $pdo->flush();

                $this->addFlash("success", "Les informations ont bien été modifiées !");
            }
    
            return $this->render('user/user.html.twig', [
                'tache' => $tache, 
                'form' => $form->createView()
            ]);
        }else{
            //produit n'existe pas 
            return $this->redirectToRoute('user');

            $this->addFlash("error", "L'id de correspond a aucune taches");
        }
    }

    /**
     * @Route("/tache/delete/{id}", name="delete_tache")
     */
    public function delete(Tache $tache=null){
        if($tache != null){
            $pdo = $this->getDoctrine()->getManager();
            $pdo->remove($tache);
            $pdo->flush();

            $this->addFlash("success", "Tache supprimé");
        }
        // si pas le bono produit selectionner
        return $this->redirectToRoute('user');
        return $this->addFlash("danger", "Tache introuvable");

    }
}
