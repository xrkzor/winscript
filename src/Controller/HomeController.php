<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index()
    {
         
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);   
    }

    /**
     * @Route("/type", name="type")
     */
    public function chooseType()
    {
        return $this->render('script/index.html.twig');
    }

    /**
     * @Route("/legal", name="legal")
     */
    public function legal()
    {
    return $this->render('home/legal.html.twig');
    }
}
