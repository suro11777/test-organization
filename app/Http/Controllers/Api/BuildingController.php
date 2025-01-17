<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BuildingResource;
use App\Models\Building;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BuildingController
{
    /**
     * @OA\Get(
     *     path="/v1/buildings",
     *     operationId="GetBuildings",
     *     tags={"Building"},
     *     summary="Получение списка зданных",
     *     @OA\Response(
     *         response="200",
     *         description="OK. Список получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     ref="#/components/schemas/BuildingResource",
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     title="first",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/buildings?page=1",
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     title="last",
     *                     type="string",
     *                     example="http://127.0.0.1:8000/api/v1/buildings?page=1",
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
     *                             "url": "http://127.0.0.1:8000/api/v1/buildings?page=1",
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
     *                     example="http://127.0.0.1:8000/api/v1/buildings",
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
    public function __invoke(): AnonymousResourceCollection
    {
        return BuildingResource::collection(
            Building::paginate(config('settings.pagination_count'))
        );
    }
}
