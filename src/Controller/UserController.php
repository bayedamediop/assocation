<?php

namespace App\Controller;
use App\Entity\User;
use ApiPlatform\Core\Filter\Validator\ValidatorInterface;
use App\Repository\ProfilsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
    /**
     * @Route(
     *  name = "addUser",
     *  path = "/api/admin/users",
     *  methods = {"POST"},
     *  defaults  = {
     *      "__controller"="App\Controller\UserController::addUser",
     *      "__api_ressource_class"=User::class,
     *      "__api_collection_operation_name"="add_users"
     * }
     * )
     */
    public function addUser(Request $request ,SerializerInterface $serialize,ProfilsRepository
    $profilsRepository,UserPasswordEncoderInterface $encoder,EntityManagerInterface $manager)

    {
        $user = $request->request->all() ;
        // dd($user);
        //get profil
        $profil = $user["profiles"] ;

        if($profil) {
            $users = $serialize->denormalize($user, "App\Entity\User");
        }
        //recupération de l'image
        $photo = $request->files->get("avatar");
        //specify entity
        //dd($photo);
        if(!$photo)
        {
            return new JsonResponse("veuillez mettre une images",Response::HTTP_BAD_REQUEST,[],true);
        }
        //$base64 = base64_decode($imagedata);
        $photoBlob = fopen($photo->getRealPath(),"rb");
        //$users = $this->serialize->denormalize($user,true);
        $password = $users->getPassword();
        $users->setAvatar($photoBlob);

        $users->setPassword($encoder->encodePassword($users,$password));

        $users->setProfil($profilsRepository->findOneBy(['libelle'=>$profil])) ;

//         $errors = $validator->validate($users);
//         if (count($errors)){
//             $errors = $this->serialize->serialize($errors,"json");
//             return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
//         }
        $em = $this->getDoctrine()->getManager();
        $em->persist($users);
        $em->flush();

        return $this->json("success",201);

    }
}
