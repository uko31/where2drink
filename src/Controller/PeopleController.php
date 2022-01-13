<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\People;

class PeopleController extends AbstractController
{
    private $requestStack;

    public function __construct(
        RequestStack $requestStack,
        UserPasswordHasherInterface $passwordHasher)
    {
        $this->requestStack = $requestStack;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/register', name: 'app_register')]
    public function index(
        Request $request, 
        EntityManagerInterface $manager): Response
    {
        $user = new People();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $form->get('password')->getData())
            );

            $manager->persist($user);
            $manager->flush();
                
            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('account/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class);

        return $this->render('account/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout() {
        $session = $this->requestStack->getSession();
        $session->set('current_user', '');
        return $this->redirectToRoute('homepage');
    }
}
