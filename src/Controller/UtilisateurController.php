<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use App\Entity\Version;
use App\Repository\VersionRepository;
use App\Form\UtilisateurType;
use App\Form\UtilisateurEditType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


class UtilisateurController extends Controller
{

   /**
    * @Route("/utilisateur/profil/", name="profil")
    */
    public function showProfil(){        
        $utilisateur = $this->getUser();

        return $this->render('utilisateur/profil.html.twig',  ['utilisateur' => $utilisateur]);
    }

    /**
     * @Route("/utilisateur/edit", name="current_user_edit")
     */
    public function editCurrentUser(ObjectManager $manager, Request $request){
        $utilisateur = $this->getUser();
        $form = $this->createForm(UtilisateurEditType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($utilisateur);
            $manager->flush();
            return $this->render('utilisateur/profil.html.twig');
        }

        $formView = $form->createView();

        return $this->render("utilisateur/edit.html.twig", [
            'form' => $formView
        ]);
    }

    /**
     * @Route("utilisateur/delete", name="utilisateur_delete")
     */
    public function deleteAction(ObjectManager $manager) {
        $utilisateur = $this->getUser();
        
        $manager->remove($utilisateur);
        $manager->flush();

        return $this->redirectToRoute('security_login');
    }
}