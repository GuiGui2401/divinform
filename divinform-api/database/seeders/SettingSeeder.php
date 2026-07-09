<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SiteSettings::registry() as $key => $def) {
            Setting::firstOrCreate(
                ['key' => $key],
                [
                    'value' => SiteSettings::encode($key, $def['default'] ?? ''),
                    'group' => $def['group'] ?? 'general',
                ]
            );
        }

        SiteSettings::flushCache();

        $this->command->info('✅ Paramètres du site initialisés ('.count(SiteSettings::registry()).' réglages).');
    }
}
