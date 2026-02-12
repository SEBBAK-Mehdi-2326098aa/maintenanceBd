<?php

namespace App\Controller;

use App\Entity\Championnat;
use App\Repository\ChampionnatRepository;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/championnat')]
class ChampionnatController extends AbstractController
{
    #[Route('/', name: 'app_championnat_index', methods: ['GET'])]
    public function index(ChampionnatRepository $championnatRepository): Response
    {
        return $this->render('championnat/index.html.twig', [
            'championnats' => $championnatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_championnat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SportRepository $sportRepository): Response
    {
        if ($request->isMethod('POST')) {
            $championnat = new Championnat();
            $championnat->setNom($request->request->get('nom'));

            $sportId = $request->request->get('sport');
            $sport = $sportRepository->find($sportId);

            if ($sport) {
                $championnat->setSport($sport);
                $entityManager->persist($championnat);
                $entityManager->flush();

                $this->addFlash('success', 'Championnat créé avec succès.');
                return $this->redirectToRoute('app_championnat_index');
            }

            $this->addFlash('error', 'Sport invalide.');
        }

        return $this->render('championnat/new.html.twig', [
            'sports' => $sportRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_championnat_show', methods: ['GET'])]
    public function show(Championnat $championnat): Response
    {
        return $this->render('championnat/show.html.twig', [
            'championnat' => $championnat,
        ]);
    }
}

