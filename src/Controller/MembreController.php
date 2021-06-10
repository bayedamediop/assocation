<?php

namespace App\Controller;
use App\Entity\Membres;
use App\Entity\Section;
use App\Repository\MembresRepository;
use App\Repository\SectionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(): Response
    {
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }
    /**
     * @Route(
     *  name = "addMembre",
     *  path = "/api/admin/membre",
     *  methods = {"POST"},
     *  defaults  = {
     *      "__controller"="App\Controller\MembreController::addMembre",
     *      "__api_ressource_class"=Membres::class,
     *      "__api_collection_operation_name"="add_membre"
     * }
     * )
     */

    public function addMembre(Request $request,TokenStorageInterface $tokenStorageInterface,
                               EntityManagerInterface $manager,SerializerInterface $serializer,
                              MembresRepository $membresRepository,UserRepository $repository,
                    SectionRepository $sectionRepository)
    {
        $json = json_decode($request->getContent());
        //recupersons le user (apprenat/formateur) connecté
        $userConnecte = $this->getUser();
        //dd($userConnecte->getSection()->getId());
       // $userConnecte =($repository->find((int)$json->user));
        //dd($id);
       //dd(substr($json->nom,0,1) );
       //dd((substr($json->nom,0,1)));
       $prenom=(strtoupper(substr($json->prenom,0,1)));
       $nom=(strtoupper(substr($json->nom,0,1)));
       //dd(strtoupper(substr($json->nom,0,1)));
        $section= $sectionRepository->find((int)$userConnecte->getSection()->getId());
       $id = $membresRepository->findOneBy([],['id'=>'desc']);
        $lastId=($id->getId()+1);
        //dd($lastId);
        $ser = "00";
        $mat=($prenom .= $nom .= $ser .= $lastId);


        $newMembre = new Membres();
        $newMembre->setNom($json->nom)
            ->setPrenom($json->prenom)
        ->setTelephone($json->telephone)
            ->setMatricule($mat)
            ->setSection($section);
        $manager->persist($newMembre);
        $manager->flush();
        return $this->json("success",201);

    }
    /**
     * @Route(
     *  name = "rechercheMembre",
     *  path = "/api/admin/membre/{mat}",
     *  methods = {"GET"},
     *  defaults  = {
     *      "__controller"="App\Controller\MembreController::rechercheMembre",
     *      "__api_ressource_class"=Membres::class,
     *      "__api_collection_operation_name"="recherche_membre"
     * }
     * )
     */
    public function rechercheMembre($mat,MembresRepository $membresRepository){
        $membre = $membresRepository->findByMatricule($mat);
        if ($membre) {
            return $this->json($membre,200,[],["groups"=>"membres:read"]);
        }else{
            return $this->json("User ou Comtpt competence inexistant");
        }

    }
}
