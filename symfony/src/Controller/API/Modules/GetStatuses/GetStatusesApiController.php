<?php

namespace App\Controller\API\Modules\GetStatuses;

use App\Modules\API\GetStatuses\Exception\RequestException;
use App\Modules\API\GetStatuses\Service\GetStatusesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetStatusesApiController extends AbstractController
{
    public function __construct(
        private readonly GetStatusesService $getStatusesService,
    )
    {
    }

    /**
     * @throws RequestException
     */
    #[Route('api/get')]
    public function get(): JsonResponse
    {
        $statuses = json_decode($this->getStatusesService->getStatuses(), true);

        return new JsonResponse($statuses);
    }
}
