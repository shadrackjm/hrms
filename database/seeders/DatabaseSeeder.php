<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure Roles exist
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $hrRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'hr_manager', 'guard_name' => 'web']);
        $employeeRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);

        // Models to protect
        $models = [
            'User', 'Department', 'Position', 'LeaveType', 
            'Attendance', 'Payroll', 'LeaveRequest', 'PerformanceReview',
            'Activity'
        ];

        $permissions = ['view', 'view_any', 'create', 'update', 'delete', 'delete_any'];

        foreach ($models as $model) {
            foreach ($permissions as $permission) {
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => "{$permission}_{$model}",
                    'guard_name' => 'web'
                ]);
            }
        }

        // Assign all to Super Admin
        $superAdmin->syncPermissions(\Spatie\Permission\Models\Permission::all());

        // Assign specific to HR
        $hrRole->syncPermissions(\Spatie\Permission\Models\Permission::where('name', 'like', '%_Attendance')
            ->orWhere('name', 'like', '%_Payroll')
            ->orWhere('name', 'like', '%_LeaveRequest')
            ->orWhere('name', 'like', '%_PerformanceReview')
            ->orWhere('name', 'like', 'view_any_User')
            ->orWhere('name', 'like', 'view_any_Department')
            ->orWhere('name', 'like', 'view_any_Position')
            ->get());

        // Assign specific to Employee
        $employeeRole->syncPermissions(\Spatie\Permission\Models\Permission::where('name', 'like', 'view_any_Attendance')
            ->orWhere('name', 'like', 'view_any_Payroll')
            ->orWhere('name', 'like', 'view_any_LeaveRequest')
            ->orWhere('name', 'like', 'view_any_PerformanceReview')
            ->orWhere('name', 'like', 'create_LeaveRequest')
            ->orWhere('name', 'like', 'update_Attendance') // for clock in/out
            ->get());

        // Create Admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($superAdmin);

        // Create HR
        $hr = User::factory()->create([
            'name' => 'HR Manager',
            'email' => 'hr@admin.com',
            'password' => bcrypt('password'),
        ]);
        $hr->assignRole($hrRole);

        // Create Employee
        $employee = User::factory()->create([
            'name' => 'Employee User',
            'email' => 'employee@admin.com',
            'password' => bcrypt('password'),
        ]);
        $employee->assignRole($employeeRole);
    }
}
