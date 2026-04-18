<?php

declare(strict_types=1);

namespace App\Web\Controller\Api;

use App\Application\DTO\ReviewDTO;
use App\Application\Exception\SaveReviewException;
use App\Application\Service\ReviewService;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route(path: '/api/review', name: 'api_review_create', methods: ['POST'])]
final class ReviewApiController extends AbstractController
{
    public function __construct(
        private readonly ReviewService $reviewService,
        #[Autowire(param: 'kernel.project_dir')]
        private readonly string $projectDir,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $resultPhotoUrl = $this->uploadResultPhoto($request->files->get('resultPhoto'));
            $reviewDTO = ReviewDTO::fromRequestData($request->request->all(), $resultPhotoUrl);
            $this->reviewService->save($reviewDTO);

            return new JsonResponse(['message' => 'Review submitted successfully.'], Response::HTTP_CREATED);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (SaveReviewException $exception) {
            return new JsonResponse(['message' => 'Review could not be saved.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $exception) {
            return new JsonResponse(['message' => 'Unexpected server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function uploadResultPhoto(mixed $resultPhoto): ?string
    {
        if (!$resultPhoto instanceof UploadedFile) {
            return null;
        }

        if (!$resultPhoto->isValid()) {
            throw new RuntimeException('Uploaded result photo is invalid.');
        }

        $mimeType = (string) $resultPhoto->getMimeType();

        if (!str_starts_with($mimeType, 'image/')) {
            throw new InvalidArgumentException('Result photo must be an image.');
        }

        $uploadDirectory = sprintf('%s/public/upload/images', $this->projectDir);

        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0o755, true) && !is_dir($uploadDirectory)) {
            throw new RuntimeException('Could not create upload directory.');
        }

        $fileName = sprintf(
            'review-result-%s.%s',
            bin2hex(random_bytes(8)),
            $resultPhoto->guessExtension() ?? 'bin'
        );

        $resultPhoto->move($uploadDirectory, $fileName);

        return $fileName;
    }
}
