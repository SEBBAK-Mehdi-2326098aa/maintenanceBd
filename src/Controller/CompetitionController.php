<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Repository\ChampionnatRepository;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/competition')]
class CompetitionController extends AbstractController
{
    #[Route('/championnat/{championnatId}', name: 'app_competition_index', methods: ['GET'])]
    public function index(int $championnatId, CompetitionRepository $competitionRepository, ChampionnatRepository $championnatRepository): Response
    {
        $championnat = $championnatRepository->find($championnatId);

        if (!$championnat) {
            throw $this->createNotFoundException('Championnat non trouvé.');
        }

        return $this->render('competition/index.html.twig', [
            'competitions' => $competitionRepository->findByChampionnat($championnatId),
            'championnat' => $championnat,
        ]);
    }

    #[Route('/new/{championnatId}', name: 'app_competition_new', methods: ['GET', 'POST'])]
    public function new(int $championnatId, Request $request, EntityManagerInterface $entityManager, ChampionnatRepository $championnatRepository): Response
    {
        $championnat = $championnatRepository->find($championnatId);

        if (!$championnat) {
            throw $this->createNotFoundException('Championnat non trouvé.');
        }

        if ($request->isMethod('POST')) {
            $competition = new Competition();
            $competition->setNom($request->request->get('nom'));
            $competition->setChampionnat($championnat);

            $entityManager->persist($competition);
            $entityManager->flush();

            $this->addFlash('success', 'Compétition créée avec succès.');
            return $this->redirectToRoute('app_competition_index', ['championnatId' => $championnatId]);
        }

        return $this->render('competition/new.html.twig', [
            'championnat' => $championnat,
        ]);
    }

    #[Route('/{id}', name: 'app_competition_show', methods: ['GET'])]
    public function show(Competition $competition): Response
    {
        return $this->render('competition/show.html.twig', [
            'competition' => $competition,
        ]);
    }
}

