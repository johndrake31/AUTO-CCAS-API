<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface as EMI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as UserPassHashInter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('auth/login.html.twig', []);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }


    /**
     * @Route("/api/register", name="register", methods={"POST"})
     * 
     */
    public function register(Request $req, SerializerInterface $serializer, EMI $emi, UserPassHashInter $hash, UserInterface $currentUser): Response
    {
        // ONLY AN ADMIN CAN REGISTER A NEW USER
        if (in_array("ROLE_ADMIN", $currentUser->getRoles())) {

            $jsonUser = $req->getContent();
            $user = $serializer->deserialize($jsonUser, User::class, 'json');
            $hashedPassword = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            // dd($user);
            $user->setRoles(["ROLE_OWNER"]);
            $emi->persist($user);
            $emi->flush();

            $data = ["user_register" => "success"];
            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "userApi"
                    ]
                ]
            );
        } else {
            $data = ["user_register" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];
            return $this->json(
                $data,
                200
            );
        }
    }

    /**
     * @Route("/api/user/index", name="index", methods={"GET"})
     * 
     */
    public function index(UserRepository $repo, UserInterface $currentUser): Response
    {
        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        // Only an Admin can have access to all user data
        if ($isAdmin) {
            $allUsers = $repo->findAll();
            $data = ["users" => $allUsers];
            return $this->json(
                $data,
                200,
                [],
                [
                    // app Entity user groups
                    "groups" => [
                        "userApi"
                    ]
                ]
            );
        } else {
            $data = ["user_index" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];
            return $this->json(
                $data,
                200
            );
        }
    }

    /**
     * @Route("/api/user/index/{id}", name="show_user_by_id", methods={"GET"})
     * @Route("/api/user/show", name="show_user", methods={"GET"})
     * 
     */
    public function show(User $user = null, UserInterface $currentUser): Response
    {
        if (!$user) {
            $user = $currentUser;
        }

        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        $data = ["user_index" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];

        //A USER HAS ACCESS TO THEIR OWN DATA, AS WEL AS AN ADMIN.
        if ($currentUser->getUserIdentifier() || $isAdmin) {
            $data = ["user_index" => $user];
            //if varified
            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "userApi"
                    ]
                ]
            );
        } else {
            //if no permissions
            return $this->json(
                $data,
                200
            );
        }
    }

    /**
     * @Route("/api/user/edit/{id}", name="edit_user", methods={"PATCH"})
     * 
     */
    public function edit(User $user, Request $req, SerializerInterface $serializer, EMI $emi, UserPassHashInter $hash, UserInterface $currentUser): Response
    {
        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        //A USER HAS ACCESS TO THEIR OWN DATA, AS WEL AS AN ADMIN.
        if ($currentUser->getUserIdentifier() == $user->getUserIdentifier()) {
            $jsonUser = $req->getContent();
            $userObj = $serializer->deserialize($jsonUser, User::class, 'json');

            $hashedPassword = $hash->hashPassword($user, $userObj->getPassword());

            $user->setFirstname($userObj->getFirstname());
            $user->setLastname($userObj->getLastname());
            $user->setTelephone($userObj->getTelephone());
            $user->setPassword($hashedPassword);
            //only an 
            if (!$isAdmin) {
                //An added layer to protect against json hack to change roles manually.
                $user->setRoles(["ROLE_OWNER"]);
            }

            $emi->persist($user);
            $emi->flush();

            $data = ["user_edit" => "success"];

            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "userApi"
                    ]
                ]
            );
        } else {
            $data = ["user_register" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];
            return $this->json(
                $data,
                200
            );
        }
    }



    /**
     * @Route("/api/user/delete/{id}", name="delete_user", methods={"DELETE"})
     * 
     */
    public function delete(User $user,  EMI $emi, UserInterface $currentUser): Response
    {
        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        if ($currentUser->getUserIdentifier() != $user->getUserIdentifier() || $isAdmin) {
            $emi->persist($user);
            $emi->flush();

            $data = ["user_delete" => "user is deleted"];
            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "userApi"
                    ]
                ]
            );
        } else {
            $data = ["user_register" => "Sooooo Sorrrry, YOU DON'T HAVE PERMISSION FOR THAT!!!"];
            return $this->json(
                $data,
                200
            );
        }
    }
}
