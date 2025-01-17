<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="BuildingResource",
     *     title="BuildingResource",
     *     type="object",
     *     @OA\Property(
     *           property="id",
     *           title="id",
     *           type="int",
     *           example="1",
     *           description="ID",
     *     ),
     *     @OA\Property(
     *         property="address",
     *         title="address",
     *         type="string",
     *         example="11534 Jonatan Neck Gerholdshire, LA 06220-1012",
     *     ),
     *     @OA\Property(
     *         property="longitude",
     *         title="longitude",
     *         type="string",
     *         example="77.9952120",
     *     ),
     *     @OA\Property(
     *         property="latitude",
     *         title="latitude",
     *         type="string",
     *         example="77.9952120",
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
     * @property string $address
     * @property string longitude
     * @property string latitude
     * @property string $created_at
     * @property string $updated_at
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
