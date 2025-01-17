<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаём виды деятельности
        $food = Activity::create(['name' => 'Еда']);
        $meat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id]);
        $milk = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id]);

        $cars = Activity::create(['name' => 'Автомобили']);
        $trucks = Activity::create(['name' => 'Грузовые', 'parent_id' => $cars->id]);
        $passenger = Activity::create(['name' => 'Легковые', 'parent_id' => $cars->id]);
        Activity::create(['name' => 'Запчасти', 'parent_id' => $passenger->id]);
        Activity::create(['name' => 'Аксессуары', 'parent_id' => $passenger->id]);

        // Создаём организации
        $org1 = Organization::create([
            'name' => 'ООО Рога и Копыта',
            'building_id' => Building::factory()->create()->id,
        ]);
        $org1->activities()->attach([$meat->id, $milk->id]);
        $org1->phones()->saveMany([
            new OrganizationPhone(['phone' => fake()->phoneNumber]),
            new OrganizationPhone(['phone' => fake()->phoneNumber]),
        ]);

        $org2 = Organization::create([
            'name' => 'ООО Автозапчасти',
            'building_id' => Building::factory()->create()->id,
        ]);
        $org2->activities()->attach([$trucks->id, $passenger->id]);
        $org2->phones()->saveMany([
            new OrganizationPhone(['phone' => fake()->phoneNumber]),
            new OrganizationPhone(['phone' => fake()->phoneNumber]),
        ]);
    }
}
