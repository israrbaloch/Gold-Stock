<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {

        $this->call(CustomMenuItemsSeeder::class);
        $this->call(CustomPermissionsSeeder::class);
        $this->call(CustomRolesSeeder::class);
        $this->call(CustomVoyagerData::class);
        $this->call(HistoricalTimeFrameSeeder::class);
    }
}
