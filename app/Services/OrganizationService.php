<?php

namespace App\Services;

use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationService
{

    public function getByRadius(array $attributes): LengthAwarePaginator
    {
        $latitude = $attributes['latitude'];
        $longitude = $attributes['longitude'];
        $radius = $attributes['radius'];

        $buildingIds = Building::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?))
                 + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                [$latitude, $longitude, $latitude]
            )
            ->having('distance', '<=', $radius)
            ->get()->pluck('id');

        return Organization::whereIn('building_id', $buildingIds)
            ->with('phones', 'activities')
            ->paginate(config('settings.pagination_count'));
    }

    public function search(array $attributes): LengthAwarePaginator
    {
        $searchText = $attributes['search_text'] ?? '';

        return Organization::when($searchText, function (Builder $query) use ($searchText) {
            $query->whereRaw('lower(organizations.name) like (?)', ["%{$searchText}%"]);
        })->paginate(config('settings.pagination_count'));
    }

    public function getByActivities($attributes): LengthAwarePaginator
    {
        $searchText = $attributes['search_text'] ?? '';

        $activities = Activity::when($searchText, function ($query) use ($searchText) {
            $query->whereRaw('lower(name) like (?)', ["%{$searchText}%"]);
        })->get();

        $activityIds = [];
        foreach ($activities as $activity) {
            $activityIds = array_merge([$activity->id], $activityIds);
            $activityIds = array_merge($activityIds, $this->getAllChildIds($activity->id));
        }

        return Organization::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->with('activities', 'phones')
            ->paginate(config('settings.pagination_count'));
    }

    private function getAllChildIds(int $parentId): array
    {
        $children = Activity::query()
            ->where('parent_id', $parentId)
            ->pluck('id');

        $allChildIds = $children->toArray();

        foreach ($children as $childId) {
            $allChildIds = array_merge($allChildIds, $this->getAllChildIds($childId));
        }

        return $allChildIds;
    }
}
