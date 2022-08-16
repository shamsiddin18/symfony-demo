<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCreateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route(
        path: '/',
        name: 'home'
    )]
    public function home(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route(
        path: '/register',
        name: 'register',
        methods: ['GET', 'POST']
    )]
    public function newUser(Request $request, ): Response
    {
        $user = new User();
        $form = $this->createForm(UserCreateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordHash = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPasswordHash($passwordHash);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function listUsers(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

//    #[Route(path: '/edit', name: "edit", methods: ['GET'])]
//    public function editUser(UserRepository $userRepository):Response
//    {
//
//    }
}
