<?php

declare(strict_types=1);

namespace App\Web\Controller\Api;

use App\Application\DTO\ApplicationDTO;
use App\Application\Exception\SaveApplicationException;
use App\Application\Service\ApplicationService;
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

#[Route(path: '/api/application', name: 'api_application_create', methods: ['POST'])]
final class ApplicationApiController extends AbstractController
{
    public function __construct(
        private readonly ApplicationService $applicationService,
        #[Autowire(param: 'kernel.project_dir')]
        private readonly string $projectDir,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $spacePhotoPath = $this->uploadSpacePhoto($request->files->get('spacePhoto'));
            $applicationDTO = ApplicationDTO::fromRequestData($request->request->all(), $spacePhotoPath);

            $this->applicationService->save($applicationDTO);

            return new JsonResponse(['message' => 'Application created successfully.'], Response::HTTP_CREATED);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (SaveApplicationException $exception) {
            return new JsonResponse(['message' => 'Application could not be created.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $exception) {
            return new JsonResponse(['message' => 'Unexpected server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function uploadSpacePhoto(mixed $spacePhoto): ?string
    {
        $uploadedFiles = $this->normalizeUploadedFiles($spacePhoto);

        if ($uploadedFiles === []) {
            return null;
        }

        $uploadDirectory = sprintf('%s/public/uploads/applications', $this->projectDir);

        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0o755, true) && !is_dir($uploadDirectory)) {
            throw new RuntimeException('Could not create upload directory.');
        }

        $uploadedPhotoPaths = [];

        foreach ($uploadedFiles as $uploadedFile) {
            if (!$uploadedFile->isValid()) {
                throw new RuntimeException('Uploaded space photo is invalid.');
            }

            $mimeType = (string) $uploadedFile->getMimeType();

            if (!str_starts_with($mimeType, 'image/')) {
                throw new InvalidArgumentException('Space photo must be an image.');
            }

            $fileName = sprintf(
                'application-%s.%s',
                bin2hex(random_bytes(8)),
                $uploadedFile->guessExtension() ?? 'bin'
            );

            $uploadedFile->move($uploadDirectory, $fileName);
            $uploadedPhotoPaths[] = sprintf('uploads/applications/%s', $fileName);
        }

        return implode(PHP_EOL, $uploadedPhotoPaths);
    }

    /**
     * @return array<UploadedFile>
     */
    private function normalizeUploadedFiles(mixed $spacePhoto): array
    {
        if ($spacePhoto instanceof UploadedFile) {
            return [$spacePhoto];
        }

        if (!is_array($spacePhoto)) {
            return [];
        }

        $uploadedFiles = [];

        foreach ($spacePhoto as $uploadedFile) {
            if ($uploadedFile instanceof UploadedFile) {
                $uploadedFiles[] = $uploadedFile;
            }
        }

        return $uploadedFiles;
    }
}
