<?php

namespace App\Controller;
use App\Entity\Utilisateurs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    /**
     * @Route(
     *  name = "addUtilisateurs",
     *  path = "/api/admin/utilisateur",
     *  methods = {"POST"},
     *  defaults  = {
     *      "__controller"="App\Controller\UtilisateurController::addUtilisateurs",
     *      "__api_ressource_class"=Utilisateurs::class,
     *      "__api_collection_operation_name"="add_membre"
     * }
     * )
     */
//
//    public function addMembre()
//    {
//
//    }
}
