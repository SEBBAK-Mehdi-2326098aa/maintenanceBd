<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sport')]
class SportController extends AbstractController
{
    #[Route('/', name: 'app_sport_index', methods: ['GET'])]
    public function index(SportRepository $sportRepository): Response
    {
        return $this->render('sport/index.html.twig', [
            'sports' => $sportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $sport = new Sport();
            $sport->setName($request->request->get('name'));

            $entityManager->persist($sport);
            $entityManager->flush();

            $this->addFlash('success', 'Sport créé avec succès.');
            return $this->redirectToRoute('app_sport_index');
        }

        return $this->render('sport/new.html.twig');
    }

    #[Route('/{id}', name: 'app_sport_show', methods: ['GET'])]
    public function show(Sport $sport): Response
    {
        return $this->render('sport/show.html.twig', [
            'sport' => $sport,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_sport_delete', methods: ['POST'])]
    public function delete(Request $request, Sport $sport, EntityManagerInterface $entityManager): Response
    {
        if ($sport->getChampionnats()->count() > 0) {
            $this->addFlash('error', 'Impossible de supprimer ce sport car il est utilisé par des championnats.');
            return $this->redirectToRoute('app_sport_show', ['id' => $sport->getId()]);
        }

        $entityManager->remove($sport);
        $entityManager->flush();

        $this->addFlash('success', 'Sport supprimé avec succès.');
        return $this->redirectToRoute('app_sport_index');
    }
}

