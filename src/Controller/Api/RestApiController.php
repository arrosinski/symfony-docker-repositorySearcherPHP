<?php

namespace App\Controller\Api;

use App\SearchInRepo\GithubSearchCodeInRepoStrategy;
use App\Service\Api\SearchCodeInRepoService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestApiController
{
    /**
     * @Route("/api/v1/code/search", methods={"GET"})
     * @OA\Get(
     *     path="/api/v1/code/search",
     *     summary="Search code in repository",
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="Code to search for",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of results per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="items", type="array", @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="repository", type="object", @OA\Property(property="owner", type="object", @OA\Property(property="login", type="string"))),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="score", type="number", format="float")
     *             ))
     *         )
     *     )
     * )
     * @Security(name="Bearer")
     */
    public function searchCodeInRepo(Request $request): JsonResponse
    {
        $searchInCodeReposeService = new SearchCodeInRepoService(new GithubSearchCodeInRepoStrategy());

        $code = htmlspecialchars($request->get('code'), ENT_QUOTES, 'UTF-8');
        $page = htmlspecialchars($request->get('page'), ENT_QUOTES, 'UTF-8');
        $perPage = htmlspecialchars($request->get('per_page'), ENT_QUOTES, 'UTF-8');

        return $searchInCodeReposeService->searchCodeInRepo($code, $page, $perPage);
    }
}
