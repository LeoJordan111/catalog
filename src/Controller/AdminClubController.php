<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminClubController extends AbstractController
{
    #[Route('/admin/club', name: 'admin_club')]
    public function index(ClubRepository $clubRepository): Response
    {
        $clubs = $clubRepository->findAll();

        return $this->render('admin_club/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }

    #[Route('/admin/club/{id}', name: 'admin_show_club')]
    public function show(
        int $id,
        ClubRepository $clubRepository
    ): Response {

        $club = $clubRepository->find($id);

        return $this->render('admin_club/club_show.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/admin/add_club', name: 'admin_add_club')]
    public function addClub(
        EntityManagerInterface $entityManager,
        request $request
    ): Response {
        $club = new Club();

        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }

        return $this->render('admin_club/club_add.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/edit_club/{id}', name: 'admin_edit_club')]
    public function upDateClub(
        int $id,
        EntityManagerInterface $entityManager,
        ClubRepository $clubRepository,
        request $request
    ): Response {

        $club = $clubRepository->find($id);

        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }

        return $this->render('admin_club/club_add.html.twig', [
            'club' => $club,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/remove_club/{id}', name: 'admin_remove_club')]
    public function removeCategory(
        int $id,
        EntityManagerInterface $entityManager,
        ClubRepository $clubRepository,
        request $request
    ): Response {

        $club = $clubRepository->find($id);


        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }


        // return $this->redirectToRoute('home');
        return $this->render('admin_club/club_remove.html.twig', [
            'club' => $club,
            'form' => $form->createView(),
        ]);
    }
}
