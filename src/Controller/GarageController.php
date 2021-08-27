<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Garage;
use App\Repository\UserRepository;
use App\Repository\GarageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface as EMI;


class GarageController extends AbstractController
{
    /**
     * @Route("/api/garage", name="garage", methods={"GET"})
     * 
     */
    public function index(GarageRepository $repo, UserInterface $currentUser): Response
    {
        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        $isOwner = in_array("ROLE_OWNER", $currentUser->getRoles());
        // Only an Admin can have access to all garage data
        if ($isAdmin || $isOwner) {
            if ($isAdmin) {
                $garages = $repo->findAll();
            }
            if ($isOwner) {
                $garages = $currentUser->getGarages();
            }
            $data = ["garages" => $garages];
            return $this->json(
                $data,
                200,
                [],
                [
                    // app Entity garage groups
                    "groups" => [
                        "garage"
                    ]
                ]
            );
        } else {
            $data = ["garage_index" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];
            return $this->json(
                $data,
                200
            );
        }
    }


    /**
     * @Route("/api/garage/add", name="add_garage", methods={"POST"})
     * 
     */
    public function add(Request $req, SerializerInterface $serializer, EMI $emi, UserInterface $currentUser): Response
    {
        // ONLY AN ADMIN CAN REGISTER A NEW USER
        if (in_array("ROLE_OWNER", $currentUser->getRoles())) {

            $garageJson = $req->getContent();
            $garage = $serializer->deserialize($garageJson, Garage::class, 'json');
            $garage->setUser($currentUser);

            $emi->persist($garage);
            $emi->flush();

            $data = ["garage_add" => "success"];
            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "garage"
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
     * @Route("/api/garage/edit/{id}", name="edit_garage", methods={"PATCH"})
     * 
     */
    public function edit(Garage $garage, Request $req, SerializerInterface $serializer, EMI $emi, UserInterface $currentUser): Response
    {
        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        //ONLY A OWNER OR ADMIN HAS ACCESS TO EDIT THEIR OWN GARAGE DATA.
        if ($currentUser->getId() == $garage->getUser()->getId() || $isAdmin) {
            $jsonGarage = $req->getContent();
            $garageObj = $serializer->deserialize($jsonGarage, Garage::class, 'json');

            $garage->setName($garageObj->getName());
            $garage->setAddress($garageObj->getAddress());
            $garage->setTelephone($garageObj->getTelephone());

            $emi->persist($garage);
            $emi->flush();

            $data = ["garage_edit" => "success"];

            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "garage"
                    ]
                ]
            );
        } else {
            $data = ["Garage_API" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];
            return $this->json(
                $data,
                200
            );
        }
    }





    /**
     * @Route("/api/garage/show/{id}", name="show_garage", methods={"GET"})
     * 
     */
    public function show(Garage $garage, UserInterface $currentUser, UserRepository $userRepo): Response
    {
        $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
        $data = ["user_index" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];

        //A USER HAS ACCESS TO THEIR OWN GARAGE DATA, AS WEL AS AN ADMIN.
        if ($currentUser->getId() == $garage->getUser()->getId() || $isAdmin) {
            $data = ["garage_index" => $garage];
            //if varified
            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "garage"
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
     * @Route("/api/garage/remove/{id}", name="remove_garage", methods={"DELETE"})
     * 
     */
    public function remove(Garage $garage, EMI $emi, UserInterface $currentUser): Response
    {
        //ONLY A OWNER HAS RIGHTS TO DELETE THEIR OWN GARAGE DATA.
        if ($currentUser->getId() == $garage->getUser()->getId()) {

            $emi->remove($garage);
            $emi->flush();

            $data = ["garage_Delet" => "success"];

            return $this->json(
                $data,
                200,
                [],
                [
                    "groups" => [
                        "garage"
                    ]
                ]
            );
        } else {
            $data = ["Garage_API" => "SOO SORRY, YOU DON'T HAVE PERMISSION FOR THAT"];
            return $this->json(
                $data,
                200
            );
        }
    }
    // end
}
