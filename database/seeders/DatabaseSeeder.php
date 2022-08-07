<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(TemplatesSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(TrialPlanSeeder::class);
        $this->call(DefaultUserSeeder::class);
        $this->call(DefaultPermissionSeeder::class);
        $this->call(DefaultRoleSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(HomePageSeeder::class);
        $this->call(FeatureSeeder::class);
        //        $this->call(TestimonailSeeder::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(AboutUsTableSeeder::class);
        $this->call(DefaultLanguageSettingsSeeder::class);
    }
}
