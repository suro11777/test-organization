<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationPhoneResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="OrganizationPhoneResource",
     *     title="OrganizationPhoneResource",
     *     type="object",
     *     @OA\Property(
     *           property="id",
     *           title="id",
     *           type="int",
     *           example="1",
     *           description="ID",
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         title="phone",
     *         type="string",
     *         example="+79177788789",
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
     * @property string $phone
     * @property string $created_at
     * @property string $updated_at
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
