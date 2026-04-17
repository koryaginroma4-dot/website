<?php

declare(strict_types=1);

namespace App\Web\Controller\Api;

use App\Application\DTO\ReviewDTO;
use App\Application\Exception\SaveReviewException;
use App\Application\Service\ReviewService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route(path: '/api/review', name: 'api_review_create', methods: ['POST'])]
final class ReviewApiController extends AbstractController
{
    public function __construct(
        private readonly ReviewService $reviewService,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $reviewDTO = ReviewDTO::fromRequestData($request->request->all());
            $this->reviewService->save($reviewDTO);

            return new JsonResponse(['message' => 'Review submitted successfully.'], JsonResponse::HTTP_CREATED);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } catch (SaveReviewException $exception) {
            return new JsonResponse(['message' => 'Review could not be saved.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $exception) {
            return new JsonResponse(['message' => 'Unexpected server error.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
