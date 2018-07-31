<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
    	
    	$utilisateur = new utilisateur();

    	$form = $this->createForm(RegistrationType::class, $utilisateur);
    	$form->handleRequest($request);
    	if($form->isSubmitted() && $form->isValid()) {
    		$hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
    		
    		$utilisateur->setPassword($hash);

    		$manager->persist($utilisateur);
    		$manager->flush();

    		return $this->redirectToRoute('security_login');
    	}
    	return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/security_login", name="security_login")
     */
    public function login(){
        
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

   /**
    * @Route("/security_logout", name="security_logout")
    */
   public function logout(){

   }
}
