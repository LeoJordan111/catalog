<?php

namespace App\Controller;

use App\Entity\League;
use App\Form\LeagueType;
use App\Repository\LeagueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'admin_category')]
    public function index(LeagueRepository $leagueRepository): Response
    {
        $leagues = $leagueRepository->findAll();

        return $this->render('admin_category/index.html.twig', [
            'leagues' => $leagues,
        ]);
    }

    #[Route('/admin/category/{id}', name: 'admin_show_category')]
    public function show(
        int $id,
        LeagueRepository $leagueRepository
    ): Response {

        $league = $leagueRepository->find($id);

        return $this->render('admin_category/category_show.html.twig', [
            'league' => $league,
        ]);
    }

    #[Route('/admin/add_category', name: 'admin_add_category')]
    public function addCategory(
        EntityManagerInterface $entityManager,
        request $request
    ): Response {

        $league = new League();

        $form = $this->createForm(LeagueType::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($league);
            $entityManager->flush();
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin_category/category_add.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/edit_category/{id}', name: 'admin_edit_category')]
    public function editCategory(
        int $id,
        EntityManagerInterface $entityManager,
        LeagueRepository $categoryRepository,
        request $request
    ): Response {

        $league = $categoryRepository->find($id);

        $form = $this->createForm(LeagueType::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($league);
            $entityManager->flush();
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin_category/category_edit.html.twig', [
            'league' => $league,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/admin/remove_category/{id}', name: 'admin_remove_category')]
    public function removeCategory(
        int $id,
        EntityManagerInterface $entityManager,
        LeagueRepository $leagueRepository,
        request $request
    ): Response {

        $league = $leagueRepository->find($id);


        $form = $this->createForm(LeagueType::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($league);
            $entityManager->flush();
            return $this->redirectToRoute('admin_category');
        }

        // return $this->redirectToRoute('home');
        return $this->render('admin_category/category_remove.html.twig', [
            'league' => $league,
            'form' => $form->createView(),
        ]);
    }
}
