<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TavernType;
use App\Entity\Address;
use App\Entity\Tavern;
use App\Entity\VoteByUser;
use App\Repository\PeopleRepository;
use App\Repository\TavernRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class TavernController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;   
    }

    #[Route('/tavern', name: 'tavern_list')]
    public function index(TavernRepository $tavernRepository): Response
    {
        $taverns = $tavernRepository->findAll();

        return $this->render('tavern/taverns.html.twig', [
            'taverns' => $taverns,
        ]);
    }

    #[Route('/tavern/new', name: 'tavern_add')]
    public function new(Request $request, EntityManagerInterface $manager, PeopleRepository $userRepository): Response
    {
        $address = new Address();
        $address->setZip('31000');
        $address->setCity('Toulouse');
        $tavern = new Tavern();
        $tavern->setAddress($address);
        $session = $this->requestStack->getSession();
        $user = $userRepository->findOneBy(['email' => $session->get('current_user')]);
        $tavern->setAddedBy($user);

        $form = $this->createForm(TavernType::class, $tavern);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            // let's add this in the database:
            $tavern = $form->getData();
            $manager->persist($tavern);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('tavern/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/tavern/{id}', name: 'tavern_detail')]
    public function tavern($id, TavernRepository $tavernRepository): Response
    {
        $tavern = $tavernRepository->findOneById($id);

        return $this->render('tavern/tavern.html.twig', [
            'tavern' => $tavern
        ]);
    }

    #[Route('/tavern/{id}/vote', name:"tavern_vote")]
    public function vote(
        $id, 
        PeopleRepository $userRepository, 
        TavernRepository $tavernRepository, 
        EntityManagerInterface $manager)
    {
        $error='there is none';
        /*
        $session = $this->requestStack->getSession();
        $user = $userRepository->findOneBy(['email' => $session->get('current_user')]);
        */
        $user = $this->getUser();
        $tavern = $tavernRepository->findOneById($id);
        
        if ( $user && $tavern) {
            try {
                $vote = new VoteByUser();
                $vote->setTavern($tavern);
                $vote->setVoter($user);
                
                $manager->persist($vote);
                $manager->flush();
            } catch (UniqueConstraintViolationException $e) {
                $error = $e->getMessage();
            }
        }     

        //dd($error);
        return $this->redirectToRoute('homepage', [
            'error' => $error,
        ]);
    }
}
