<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shop')]
final class ShopController extends AbstractController
{
    #[Route('', name: 'shop')]
    public function index(): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }

    #[Route('/single/{id}', name: 'shop_single')] //, requirements: ['id' => '\d+'])
    public function single(int $id, ClubRepository $ClubRepository): Response
    {
        $club = $ClubRepository->find($id);
        // dd($club);

        return $this->render('shop/single.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/category/{id}', name: 'shop_category')] //, requirements: ['id' => '\d+'])
    public function bycategory(int $id, ClubRepository $ClubRepository): Response
    {

        $clubs = $ClubRepository->findBy([
            'league' => $id,
        ]);
        // dd($clubs);
        return $this->render('shop/category.html.twig', [
            'clubs' => $clubs,
        ]);
    }
}
