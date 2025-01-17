<?php

namespace App\Http\Resources;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class OrganizationResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="OrganizationResource",
     *     title="OrganizationResource",
     *     type="object",
     *     @OA\Property(
     *           property="id",
     *           title="id",
     *           type="int",
     *           example="1",
     *           description="ID",
     *     ),
     *     @OA\Property(
     *         property="name",
     *         title="name",
     *         type="string",
     *         example="ООО Рога и Копыта",
     *     ),
     *     @OA\Property(
     *         property="phones",
     *         type="array",
     *         @OA\Items(
     *             ref="#/components/schemas/OrganizationPhoneResource",
     *         ),
     *     ),
     *     @OA\Property(
     *         property="activities",
     *         type="array",
     *         @OA\Items(
     *             ref="#/components/schemas/ActivityResource",
     *         ),
     *     ),
     *     @OA\Property(
     *         property="building",
     *         type="array",
     *         @OA\Items(
     *             ref="#/components/schemas/BuildingResource",
     *         ),
     *     ),
     *      @OA\Property(
     *         property="created_at",
     *         title="created_at",
     *         type="string",
     *         example="1970-01-01T00:00:00.000000Z",
     *         description="Дата и время создания",
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         title="updated_at",
     *         type="string",
     *         example="1970-01-01T00:00:00.000000Z",
     *         description="Дата и время обновления",
     *     ),
     * )
     * @property int $id
     * @property string $name
     * @property Collection $phones
     * @property Collection $activities
     * @property Building $building
     * @property string $created_at
     * @property string $updated_at
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phones' => OrganizationPhoneResource::collection($this->phones),
            'activities' => ActivityResource::collection($this->activities),
            'building' => BuildingResource::make($this->building),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
