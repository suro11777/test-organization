<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRadiusRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/v1/organizations/buildings/{buildingId}",
     *     operationId="GetOrganizationByBuilding",
     *     tags={"Organization"},
     *     summary="Получение списка всех организаций находящихся в конкретном здании",
     *     @OA\Parameter(
     *         name="buildingId",
     *         in="path",
     *         description="ID здании.",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Список получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/OrganizationResource",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     title="first",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/buildings/2?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     title="last",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/buildings/2?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     title="prev",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     title="next",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     title="current_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     title="from",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     title="last_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="object",
     *                     example={
     *                         {
     *                             "url": null,
     *                             "label": "&laquo; Previous",
     *                             "active": false
     *                         },
     *                         {
     *                             "url": "http://127.0.0.1:8000/api/v1/organizations/buildings/2?page=1",
     *                             "label": "1",
     *                             "active": true
     *                         },
     *                         {
     *                             "url": null,
     *                             "label": "Next &raquo;",
     *                             "active": false
     *                         }
     *                     },
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     title="path",
     *                     type="null|string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/buildings/2",
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     title="per_page",
     *                     type="int",
     *                     example="15",
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     title="to",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     title="total",
     *                     type="int",
     *                     example="1",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getByBuilding(int $buildingId): AnonymousResourceCollection
    {
        return OrganizationResource::collection(
            Organization::where('building_id', $buildingId)
                ->with('phones', 'activities')
                ->paginate(config('settings.pagination_count'))
        );
    }

    /**
     * @OA\Get(
     *     path="/v1/organizations/{organization}",
     *     operationId="GetOrganizationById",
     *     tags={"Organization"},
     *     summary="Получение информации об организации по её идентификатору",
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         description="ID организаци.",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Информация получена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/OrganizationResource",
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getById(Organization $organization): OrganizationResource
    {
        return OrganizationResource::make(
            $organization
        );
    }

    /**
     * @OA\Get(
     *     path="/v1/organizations/activities/{activityId}",
     *     operationId="GetOrganizationByActivity",
     *     tags={"Organization"},
     *     summary="Получение списка всех организаций, которые относятся к указанному виду деятельности",
     *     @OA\Parameter(
     *         name="activityId",
     *         in="path",
     *         description="ID деятельности.",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Список получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/OrganizationResource",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     title="first",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/activities/2?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     title="last",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/activities/2?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     title="prev",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     title="next",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     title="current_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     title="from",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     title="last_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="object",
     *                     example={
     *                         {
     *                             "url": null,
     *                             "label": "&laquo; Previous",
     *                             "active": false
     *                         },
     *                         {
     *                             "url": "http://127.0.0.1:8000/api/v1/organizations/activities/2?page=1",
     *                             "label": "1",
     *                             "active": true
     *                         },
     *                         {
     *                             "url": null,
     *                             "label": "Next &raquo;",
     *                             "active": false
     *                         }
     *                     },
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     title="path",
     *                     type="null|string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/activities/2",
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     title="per_page",
     *                     type="int",
     *                     example="15",
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     title="to",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     title="total",
     *                     type="int",
     *                     example="1",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getByActivity(int $activityId): AnonymousResourceCollection
    {
        return OrganizationResource::collection(
            Organization::whereHas('activities', function ($query) use ($activityId) {
                $query->where('activities.id', $activityId);
            })->with('activities', 'phones')
                ->paginate(config('settings.pagination_count'))
        );
    }

    /**
     * @OA\Get(
     *     path="/v1/organizations/radius",
     *     operationId="GetOrganizationByRadius",
     *     tags={"Organization"},
     *     summary="Получение списка всех организаций, которые находятся в заданном радиусе/прямоугольной области",
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         description="Радиус поиска",
     *         example="156",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         description="Широта.",
     *         example="-11.4353650",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         description="Долгота",
     *         example="108.4345110",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Список получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/OrganizationResource",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     title="first",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/radius?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     title="last",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/radius?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     title="prev",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     title="next",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     title="current_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     title="from",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     title="last_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="object",
     *                     example={
     *                         {
     *                             "url": null,
     *                             "label": "&laquo; Previous",
     *                             "active": false
     *                         },
     *                         {
     *                             "url": "http://127.0.0.1:8000/api/v1/organizations/radius?page=1",
     *                             "label": "1",
     *                             "active": true
     *                         },
     *                         {
     *                             "url": null,
     *                             "label": "Next &raquo;",
     *                             "active": false
     *                         }
     *                     },
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     title="path",
     *                     type="null|string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/radius",
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     title="per_page",
     *                     type="int",
     *                     example="15",
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     title="to",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     title="total",
     *                     type="int",
     *                     example="1",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getByRadius(SearchRadiusRequest $request): AnonymousResourceCollection
    {
        return OrganizationResource::collection(
            $this->service->getByRadius($request->validated())
        );
    }

    /**
     * @OA\Get(
     *     path="/v1/organizations",
     *     operationId="GetOrganization",
     *     tags={"Organization"},
     *     summary="Получение списка всех организаций по названию",
     *     @OA\Parameter(
     *         name="serach_text",
     *         in="query",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Список получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/OrganizationResource",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     title="first",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     title="last",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     title="prev",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     title="next",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     title="current_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     title="from",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     title="last_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="object",
     *                     example={
     *                         {
     *                             "url": null,
     *                             "label": "&laquo; Previous",
     *                             "active": false
     *                         },
     *                         {
     *                             "url": "http://127.0.0.1:8000/api/v1/organizations?page=1",
     *                             "label": "1",
     *                             "active": true
     *                         },
     *                         {
     *                             "url": null,
     *                             "label": "Next &raquo;",
     *                             "active": false
     *                         }
     *                     },
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     title="path",
     *                     type="null|string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations",
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     title="per_page",
     *                     type="int",
     *                     example="15",
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     title="to",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     title="total",
     *                     type="int",
     *                     example="1",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        return OrganizationResource::collection(
            $this->service->search($request->all())
        );
    }

    /**
     * @OA\Get(
     *     path="/v1/organizations/search/activities",
     *     operationId="GetOrganizationSearchActivities",
     *     tags={"Organization"},
     *     summary="Получение списка всех организаций по виду деятельности",
     *     @OA\Parameter(
     *         name="serach_text",
     *         in="query",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Список получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/OrganizationResource",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     title="first",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/search/activities?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     title="last",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/search/activities?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     title="prev",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     title="next",
     *                     type="null|string",
     *                     example="null",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     title="current_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     title="from",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     title="last_page",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="object",
     *                     example={
     *                         {
     *                             "url": null,
     *                             "label": "&laquo; Previous",
     *                             "active": false
     *                         },
     *                         {
     *                             "url": "http://127.0.0.1:8000/api/v1/organizations/search/activities?page=1",
     *                             "label": "1",
     *                             "active": true
     *                         },
     *                         {
     *                             "url": null,
     *                             "label": "Next &raquo;",
     *                             "active": false
     *                         }
     *                     },
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     title="path",
     *                     type="null|string",
     *                     example="http://127.0.0.1:8000/api/v1/organizations/search/activities",
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     title="per_page",
     *                     type="int",
     *                     example="15",
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     title="to",
     *                     type="int",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     title="total",
     *                     type="int",
     *                     example="1",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getByActivities(Request $request): AnonymousResourceCollection
    {
        return OrganizationResource::collection(
            $this->service->getByActivities($request->all())
        );
    }


}
