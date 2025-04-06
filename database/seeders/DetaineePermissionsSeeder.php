<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DetaineePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $module = 'detainees';

        $permissions = [
            'create',
            'read',
            'update',
            'delete'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => "detainees-$perm",
            ], [
                'table' => $module,
            ]);
        }

        $this->command->info('✅ تمت إضافة صلاحيات الأسرى تحت مجموعة "' . $module . '"');
    }
}
