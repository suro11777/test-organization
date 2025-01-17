<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class ActivityResource extends JsonResource
{
    /**
     * /**
     * @OA\Schema(
     *     schema="ActivityResource",
     *     title="ActivityResource",
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
     *         example="Еда",
     *     ),
     *     @OA\Property(
     *         property="parent_id",
     *         title="parent_id",
     *         type="integer",
     *         example="1",
     *     ),
     *     @OA\Property(
     *          property="children",
     *          type="array",
     *          @OA\Items(
     *              ref="#/components/schemas/ActivityResource",
     *          ),
     *      ),
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
     * @property string $parent_id
     * @property Collection $children
     * @property string $created_at
     * @property string $updated_at
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'children' => $this->when($this->children->isNotEmpty(), ActivityResource::collection($this->children)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
