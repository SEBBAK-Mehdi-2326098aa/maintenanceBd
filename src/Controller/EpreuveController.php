<?php

namespace App\Controller;

use App\Entity\Epreuve;
use App\Repository\CompetitionRepository;
use App\Repository\EpreuveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/epreuve')]
class EpreuveController extends AbstractController
{
    #[Route('/competition/{competitionId}', name: 'app_epreuve_index', methods: ['GET'])]
    public function index(int $competitionId, EpreuveRepository $epreuveRepository, CompetitionRepository $competitionRepository): Response
    {
        $competition = $competitionRepository->find($competitionId);

        if (!$competition) {
            throw $this->createNotFoundException('Compétition non trouvée.');
        }

        return $this->render('epreuve/index.html.twig', [
            'epreuves' => $epreuveRepository->findByCompetition($competitionId),
            'competition' => $competition,
        ]);
    }

    #[Route('/new/{competitionId}', name: 'app_epreuve_new', methods: ['GET', 'POST'])]
    public function new(int $competitionId, Request $request, EntityManagerInterface $entityManager, CompetitionRepository $competitionRepository): Response
    {
        $competition = $competitionRepository->find($competitionId);

        if (!$competition) {
            throw $this->createNotFoundException('Compétition non trouvée.');
        }

        if ($request->isMethod('POST')) {
            $epreuve = new Epreuve();
            $epreuve->setNom($request->request->get('nom'));
            $epreuve->setType($request->request->get('type'));
            $epreuve->setCompetition($competition);

            $entityManager->persist($epreuve);
            $entityManager->flush();

            $this->addFlash('success', 'Épreuve créée avec succès.');
            return $this->redirectToRoute('app_epreuve_index', ['competitionId' => $competitionId]);
        }

        return $this->render('epreuve/new.html.twig', [
            'competition' => $competition,
            'types' => Epreuve::getTypeChoices(),
        ]);
    }

    #[Route('/{id}', name: 'app_epreuve_show', methods: ['GET'])]
    public function show(Epreuve $epreuve): Response
    {
        return $this->render('epreuve/show.html.twig', [
            'epreuve' => $epreuve,
        ]);
    }
}

