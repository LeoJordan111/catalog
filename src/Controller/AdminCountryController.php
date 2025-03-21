<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminCountryController extends AbstractController
{
    #[Route('/admin/country', name: 'admin_country')]
    public function index(CountryRepository $countryRepository): Response
    {

        $countries = $countryRepository->findAll();

        return $this->render('admin_country/index.html.twig', [
            'countries' => $countries,
        ]);
    }

    #[Route('/admin/country/{id}', name: 'admin_show_country')]
    public function show(
        int $id,
        CountryRepository $countryRepository
    ): Response {

        $country = $countryRepository->find($id);

        return $this->render('admin_country/country_show.html.twig', [
            'country' => $country,
        ]);
    }

    #[Route('/admin/add_country', name: 'admin_add_country')]
    public function addCountry(
        EntityManagerInterface $entityManager,
        request $request
    ): Response {

        $country = new Country();

        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($country);
            $entityManager->flush();
            return $this->redirectToRoute('admin_country');
        }

        return $this->render('admin_country/country_add.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/edit_country/{id}', name: 'admin_edit_country')]
    public function editCountry(
        int $id,
        EntityManagerInterface $entityManager,
        CountryRepository $countryRepository,
        request $request
    ): Response {

        $country = $countryRepository->find($id);

        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($country);
            $entityManager->flush();
            return $this->redirectToRoute('admin_country');
        }

        return $this->render('admin_country/country_edit.html.twig', [
            'country' => $country,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/remove_country/{id}', name: 'admin_remove_country')]
    public function removeCountry(
        int $id,
        EntityManagerInterface $entityManager,
        CountryRepository $countryRepository,
        request $request
    ): Response {

        $country = $countryRepository->find($id);

        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($country);
            $entityManager->flush();
            return $this->redirectToRoute('admin_country');
        }

        return $this->render('admin_country/country_remove.html.twig', [
            'country' => $country,
            'form' => $form->createView(),
        ]);
    }
}
