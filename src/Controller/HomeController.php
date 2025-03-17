<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(ClubRepository $ClubRepository): Response
    {
        $clubs = $ClubRepository->findAll();

        return $this->render('home/index.html.twig', [
            'clubs' => $clubs,
        ]);
    }
}
