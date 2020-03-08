<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(Request $request)
    {
        $pdo = $this->getDoctrine()->getManager();
        
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        //analyse la requete HTTP
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $user->setDate(new \DateTime('now')); 
            //le form a été envoyé, on le sauvegarde
            $pdo->persist($user); //prepare
        $pdo->flush() ;          //execute

            // rénitialisation du formulaire
            unset($entity);
            unset($form);
            $user = new User();
            $form = $this->createForm(UserFormType::class, $user);

            $this->addFlash("success", "Utilisateur ajouté !");
            
        }

        $allUsers = $pdo->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'user' => $allUsers,
            'UserForm' => $form->createView()
        ]);
    }

     /**
     * @Route("user/{id}", name="utilisateur")
     */
    public function userModif(Request $request, User $user=null){

        if($user != null){
            $form = $this->createForm(UserFormType::class, $user);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                $pdo = $this->getDoctrine()->getManager();
                
                $pdo->persist($user);
                $pdo->flush();

                $this->addFlash("success", "Les informations ont bien été modifiées !");
            }
    
            return $this->render('user/user.html.twig', [
                'user' => $user, 
                'form' => $form->createView()
            ]);
        }else{
            //produit n'existe pas 
            return $this->redirectToRoute('user');

            $this->addFlash("error", "L'id de correspond a aucun des utilisateurs");
        }
    }

    /**
     * @Route("/user/delete/{id}", name="delete_user")
     */
    public function delete(User $user=null){
        if($user != null){
            $pdo = $this->getDoctrine()->getManager();
            $pdo->remove($user);
            $pdo->flush();

            $this->addFlash("success", "Utilisateur supprimé");
        }
        // si pas le bono produit selectionner
        return $this->redirectToRoute('user');
        return $this->addFlash("danger", "Utilisateur introuvable");

    }
}
