<?php

namespace App\Trainings\Infrastructure\Controller;

use App\Trainings\Application\Payload\CreateTrainingPayload;
use App\Trainings\Application\Payload\UpdateTrainingPayload;
use App\Trainings\Application\Services\TrainingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

// TODO: Use specific exceptions and handle specific exception cases in endpoints.
#[Route(path: '/training')]
class TrainingController extends AbstractController
{
    public function __construct(
        private readonly TrainingManager $trainingManager
    )
    {
    }

    #[Route(path: '/', methods: ['GET'])]
    public function getList(
        #[MapQueryParameter] string $trainingName = null,
        #[MapQueryParameter] string $lecturerName = null,
        #[MapQueryParameter] string $trainingTerm = null,
    ): JsonResponse {
        return $this->json([
            'list' => $this->trainingManager->getTrainingList($trainingName, $trainingTerm, $lecturerName)
        ]);
    }

    #[Route(path: '/exactDateCount/{date}', methods: ['GET'])]
    public function getCountForExactDate(string $date): JsonResponse
    {
        return $this->json([
            'numberOfTrainings' => $this->trainingManager->getTrainingCount($date)
        ]);
    }

    #[Route(path: '/', methods: ['POST'])]
    public function createTraining(
        #[MapRequestPayload] CreateTrainingPayload $payload
    ): Response
    {
        $this->trainingManager->createTraining($payload);
        return new Response('', Response::HTTP_ACCEPTED);
    }

    #[Route(path: '/{trainingId}', methods: ['GET'])]
    public function getTraining(string $trainingId): JsonResponse
    {
        return $this->json([
            'training' => $this->trainingManager->getTraining($trainingId)
        ]);
    }

    #[Route(path: '/{trainingId}', methods: ['PATCH'])]
    public function updateTraining(
        string $trainingId,
        #[MapRequestPayload] UpdateTrainingPayload $payload
    ): Response {
        $this->trainingManager->updateTraining($trainingId, $payload);
        return new Response('', Response::HTTP_ACCEPTED);
    }

    #[Route(path: '/{trainingId}', methods: ['DELETE'])]
    public function deleteTraining(string $trainingId): Response
    {
        $this->trainingManager->deleteTraining($trainingId);
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
