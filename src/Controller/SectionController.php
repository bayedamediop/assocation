<?php

namespace App\Controller;
use App\Entity\Section;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SectionController extends AbstractController
{
    /**
     * @Route("/section", name="section")
     */
    public function index(): Response
    {
        return $this->render('section/index.html.twig', [
            'controller_name' => 'SectionController',
        ]);
    }
    /**
     * @Route(
     *  name = "addSection",
     *  path = "/api/admin/section",
     *  methods = {"POST"},
     *  defaults  = {
     *      "__controller"="App\Controller\SectionController::addSection",
     *      "__api_ressource_class"=Section::class,
     *      "__api_collection_operation_name"="add_section"
     * }
     * )
     */
    public function addSection(Request $request,TokenStorageInterface $tokenStorageInterface,
                               EntityManagerInterface $manager,SerializerInterface $serializer,UserRepository $repository)
    {
        $json = json_decode($request->getContent());
        //recupersons le user (apprenat/formateur) connecté
        $user = $tokenStorageInterface->getToken()->getUser();
       $id=($user->getId());
       $userConnecte =($repository->find((int)$json->user));
         //dd($id);
        $newSection = new Section();
        $newSection->setLibelle($json->libelle)
            ->setSomme(0);
        $newSection->setUser($userConnecte);
        $manager->persist($newSection);
        $manager->flush();
        return $this->json("success",201);


    }
}
