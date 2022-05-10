<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups ;
use Symfony\Component\Serializer\SerializerInterface;
use Lcobucci\JWT\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

// user mobile
class MobileController extends AbstractController
{

    /**
     * @Route("/signupMobile", name="signupMobile")
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer): Response
    {
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $numtel = $request->query->get("numtel");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("email invalid");
        }
        $user = new Admin();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setNumtel($numtel);
        $user->setRoles('ROLE_ADMIN');
        try {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse("Account is created", 200);
        } catch (\Exception$ex) {
            return new Response("exception" . $ex->getMessage());
        }


    }

    /**
     * @Route("/signinMobile", name="signinMobile")
     */
    public function signinAction(Request $request, SerializerInterface $serializer)
    {
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Admin::class)->findOneBy(['email' => $email]);
        if ($user) {
            if ($password == $user->getPassword()) {
                $formatted = $serializer->normalize($user, 'json', ['groups' => 'post:read']);
                return new Response(json_encode($formatted));

            } else {

                return new Response("passowrd not found");
            }
        } else {
            return new Response("Admin not found");
        }

    }

    /**
     * @Route("/editUserMobile", name="editUserMobile")
     */
    public function editUserMobile(Request $request, SerializerInterface $serializer, UserPasswordEncoderInterface $encoder)
    {
        $id = $request->query->get("id");
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $numtel = $request->query->get("numtel");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Admin::class)->findOneBy(['email' => $email]);
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setNumtel($numtel);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new JsonResponse("success", 200);
        } catch (\Exception $ex) {
            return new Response("fail" . $ex->getMessage());
        }
    }
}