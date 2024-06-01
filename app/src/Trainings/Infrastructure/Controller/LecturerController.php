<?php

namespace App\Trainings\Infrastructure\Controller;

use App\Trainings\Application\Payload\CreateLecturerPayload;
use App\Trainings\Application\Services\LecturerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

// TODO: Use specific exceptions and handle specific exception cases in endpoints.
#[Route(path: '/lecturer')]
class LecturerController extends AbstractController
{
    public function __construct(
        private readonly LecturerManager $lecturerManager
    )
    {
    }

    #[Route(path: '/', methods: ['POST'])]
    public function createLecturer(
        #[MapRequestPayload] CreateLecturerPayload $payload
    ): Response
    {
        $this->lecturerManager->createLecturer($payload);
        return new Response('', Response::HTTP_ACCEPTED);
    }

    #[Route(path: '/{lecturerId}', methods: ['GET'])]
    public function getLecturer(string $lecturerId): JsonResponse
    {
        return $this->json([
            'lecturer' => $this->lecturerManager->getLecturer($lecturerId)
        ]);
    }

    #[Route(path: '/{lecturerId}/trainings', methods: ['GET'])]
    public function getLecturerWithTraining(string $lecturerId): JsonResponse
    {
        return $this->json([
            'lecturer' => $this->lecturerManager->getLecturerWithTrainings($lecturerId)
        ]);
    }
}
