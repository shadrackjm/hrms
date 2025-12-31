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
        // ==========================================
        // 1. ROLES & PERMISSIONS
        // ==========================================
        $this->seedRolesAndPermissions();

        // ==========================================
        // 2. DEPARTMENTS
        // ==========================================
        $departments = $this->seedDepartments();

        // ==========================================
        // 3. POSITIONS
        // ==========================================
        $positions = $this->seedPositions($departments);

        // ==========================================
        // 4. LEAVE TYPES
        // ==========================================
        $leaveTypes = $this->seedLeaveTypes();

        // ==========================================
        // 5. USERS (Admin, HR, Employees)
        // ==========================================
        $users = $this->seedUsers($departments, $positions);

        // ==========================================
        // 6. ATTENDANCE RECORDS
        // ==========================================
        $this->seedAttendance($users);

        // ==========================================
        // 7. LEAVE REQUESTS
        // ==========================================
        $this->seedLeaveRequests($users, $leaveTypes);

        // ==========================================
        // 8. PAYROLL
        // ==========================================
        $this->seedPayroll($users);

        // ==========================================
        // 9. PERFORMANCE REVIEWS
        // ==========================================
        $this->seedPerformanceReviews($users);
    }

    /**
     * Seed roles and permissions
     */
    private function seedRolesAndPermissions(): void
    {
        // Create Roles
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $hrRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'hr_manager', 'guard_name' => 'web']);
        $employeeRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);

        // Models to protect
        $models = [
            'User', 'Department', 'Position', 'LeaveType', 
            'Attendance', 'Payroll', 'LeaveRequest', 'PerformanceReview',
            'Activity', 'Role', 'CheckInOut'
        ];

        // Filament Shield standard prefixes
        $prefixes = ['View', 'ViewAny', 'Create', 'Update', 'Delete', 'DeleteAny', 'Restore', 'RestoreAny', 'Replicate', 'Reorder', 'Page', 'Widget'];

        // Create permissions
        foreach ($models as $model) {
            foreach ($prefixes as $prefix) {
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => "{$prefix}:{$model}",
                    'guard_name' => 'web'
                ]);
            }
        }

        // Assign all permissions to Super Admin
        $superAdmin->syncPermissions(\Spatie\Permission\Models\Permission::all());

        // Assign specific permissions to HR Manager
        $hrRole->syncPermissions(\Spatie\Permission\Models\Permission::where('name', 'like', '%:Attendance')
            ->orWhere('name', 'like', '%:Payroll')
            ->orWhere('name', 'like', '%:LeaveRequest')
            ->orWhere('name', 'like', '%:PerformanceReview')
            ->orWhere('name', 'like', '%:User')
            ->orWhere('name', 'like', '%:Department')
            ->orWhere('name', 'like', '%:Position')
            ->orWhere('name', 'like', '%:LeaveType')
            ->get());

        // Assign specific permissions to Employee
        $employeeRole->syncPermissions(\Spatie\Permission\Models\Permission::where('name', 'like', 'ViewAny:Attendance')
            ->orWhere('name', 'like', 'View:Attendance')
            ->orWhere('name', 'like', 'ViewAny:Payroll')
            ->orWhere('name', 'like', 'View:Payroll')
            ->orWhere('name', 'like', 'ViewAny:LeaveRequest')
            ->orWhere('name', 'like', 'View:LeaveRequest')
            ->orWhere('name', 'like', 'Create:LeaveRequest')
            ->orWhere('name', 'like', 'ViewAny:PerformanceReview')
            ->orWhere('name', 'like', 'View:PerformanceReview')
            ->orWhere('name', 'like', 'Page:CheckInOut')
            ->orWhere('name', 'like', 'Update:Attendance') // for clock in/out
            ->get());
    }

    /**
     * Seed departments
     */
    private function seedDepartments(): array
    {
        $departmentData = [
            ['name' => 'Information Technology', 'code' => 'IT', 'color' => '#3B82F6'],
            ['name' => 'Human Resources', 'code' => 'HR', 'color' => '#10B981'],
            ['name' => 'Finance', 'code' => 'FIN', 'color' => '#F59E0B'],
            ['name' => 'Marketing', 'code' => 'MKT', 'color' => '#EF4444'],
            ['name' => 'Operations', 'code' => 'OPS', 'color' => '#8B5CF6'],
            ['name' => 'Sales', 'code' => 'SAL', 'color' => '#EC4899'],
        ];

        $departments = [];
        foreach ($departmentData as $data) {
            $departments[] = \App\Models\Department::firstOrCreate(
                ['code' => $data['code']],
                $data
            );
        }

        return $departments;
    }

    /**
     * Seed positions
     */
    private function seedPositions(array $departments): array
    {
        $positionData = [
            // IT Department
            ['title' => 'IT Manager', 'department_id' => $departments[0]->id, 'min_salary' => 13000000, 'max_salary' => 18000000],
            ['title' => 'Senior Developer', 'department_id' => $departments[0]->id, 'min_salary' => 10000000, 'max_salary' => 15000000],
            ['title' => 'Junior Developer', 'department_id' => $departments[0]->id, 'min_salary' => 6000000, 'max_salary' => 9000000],
            ['title' => 'System Administrator', 'department_id' => $departments[0]->id, 'min_salary' => 8000000, 'max_salary' => 12000000],
            
            // HR Department
            ['title' => 'HR Manager', 'department_id' => $departments[1]->id, 'min_salary' => 11000000, 'max_salary' => 16000000],
            ['title' => 'HR Specialist', 'department_id' => $departments[1]->id, 'min_salary' => 7000000, 'max_salary' => 10000000],
            ['title' => 'Recruiter', 'department_id' => $departments[1]->id, 'min_salary' => 6500000, 'max_salary' => 9500000],
            
            // Finance Department
            ['title' => 'Finance Manager', 'department_id' => $departments[2]->id, 'min_salary' => 12000000, 'max_salary' => 17000000],
            ['title' => 'Accountant', 'department_id' => $departments[2]->id, 'min_salary' => 7500000, 'max_salary' => 11000000],
            ['title' => 'Finance Analyst', 'department_id' => $departments[2]->id, 'min_salary' => 8000000, 'max_salary' => 12000000],
            
            // Marketing Department
            ['title' => 'Marketing Manager', 'department_id' => $departments[3]->id, 'min_salary' => 11000000, 'max_salary' => 16000000],
            ['title' => 'Content Creator', 'department_id' => $departments[3]->id, 'min_salary' => 6000000, 'max_salary' => 9000000],
            ['title' => 'Social Media Specialist', 'department_id' => $departments[3]->id, 'min_salary' => 6500000, 'max_salary' => 9500000],
            
            // Operations Department
            ['title' => 'Operations Manager', 'department_id' => $departments[4]->id, 'min_salary' => 11500000, 'max_salary' => 16500000],
            ['title' => 'Operations Coordinator', 'department_id' => $departments[4]->id, 'min_salary' => 7000000, 'max_salary' => 10000000],
            
            // Sales Department
            ['title' => 'Sales Manager', 'department_id' => $departments[5]->id, 'min_salary' => 12000000, 'max_salary' => 17000000],
            ['title' => 'Sales Executive', 'department_id' => $departments[5]->id, 'min_salary' => 7500000, 'max_salary' => 11000000],
        ];

        $positions = [];
        foreach ($positionData as $data) {
            $positions[] = \App\Models\Position::firstOrCreate(
                ['title' => $data['title'], 'department_id' => $data['department_id']],
                $data
            );
        }

        return $positions;
    }

    /**
     * Seed leave types
     */
    private function seedLeaveTypes(): array
    {
        $leaveTypesData = [
            ['name' => 'Annual Leave', 'days_per_year' => 12, 'is_paid' => true],
            ['name' => 'Sick Leave', 'days_per_year' => 10, 'is_paid' => true],
            ['name' => 'Emergency Leave', 'days_per_year' => 5, 'is_paid' => true],
            ['name' => 'Maternity Leave', 'days_per_year' => 90, 'is_paid' => true],
            ['name' => 'Paternity Leave', 'days_per_year' => 7, 'is_paid' => true],
            ['name' => 'Unpaid Leave', 'days_per_year' => 30, 'is_paid' => false],
        ];

        $leaveTypes = [];
        foreach ($leaveTypesData as $data) {
            $leaveTypes[] = \App\Models\LeaveType::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        return $leaveTypes;
    }

    /**
     * Seed users
     */
    private function seedUsers(array $departments, array $positions): array
    {
        // Get roles
        $superAdmin = \Spatie\Permission\Models\Role::where('name', 'super_admin')->first();
        $hrRole = \Spatie\Permission\Models\Role::where('name', 'hr_manager')->first();
        $employeeRole = \Spatie\Permission\Models\Role::where('name', 'employee')->first();

        $users = [];

        // Create Super Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'employee_id' => 'EMP001',
                'status' => 'active',
                'department_id' => $departments[0]->id, // IT
                'position_id' => $positions[0]->id, // IT Manager
                'hire_date' => now()->subYears(5),
                'phone' => '+62 812-3456-7890',
                'address' => 'Jakarta, Indonesia',
            ]
        );
        $admin->assignRole($superAdmin);
        $users[] = $admin;

        // Create HR Manager
        $hr = User::updateOrCreate(
            ['email' => 'hr@hr.com'],
            [
                'name' => 'HR Manager',
                'password' => bcrypt('password'),
                'employee_id' => 'EMP002',
                'status' => 'active',
                'department_id' => $departments[1]->id, // HR
                'position_id' => $positions[4]->id, // HR Manager
                'hire_date' => now()->subYears(3),
                'phone' => '+62 813-4567-8901',
                'address' => 'Jakarta, Indonesia',
            ]
        );
        $hr->assignRole($hrRole);
        $users[] = $hr;

        // Create Sample Employees
        $sampleEmployees = [
            [
                'name' => 'John Developer',
                'email' => 'john@employee.com',
                'employee_id' => 'EMP003',
                'department_id' => $departments[0]->id,
                'position_id' => $positions[1]->id, // Senior Developer
                'phone' => '+62 814-5678-9012',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@employee.com',
                'employee_id' => 'EMP004',
                'department_id' => $departments[2]->id,
                'position_id' => $positions[8]->id, // Accountant
                'phone' => '+62 815-6789-0123',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@employee.com',
                'employee_id' => 'EMP005',
                'department_id' => $departments[3]->id,
                'position_id' => $positions[11]->id, // Content Creator
                'phone' => '+62 816-7890-1234',
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah@employee.com',
                'employee_id' => 'EMP006',
                'department_id' => $departments[5]->id,
                'position_id' => $positions[16]->id, // Sales Executive
                'phone' => '+62 817-8901-2345',
            ],
        ];

        foreach ($sampleEmployees as $empData) {
            $employee = User::updateOrCreate(
                ['email' => $empData['email']],
                array_merge($empData, [
                    'password' => bcrypt('password'),
                    'status' => 'active',
                    'hire_date' => now()->subYears(rand(1, 4)),
                    'address' => 'Jakarta, Indonesia',
                ])
            );
            $employee->assignRole($employeeRole);
            $users[] = $employee;
        }


        return $users;
    }

    /**
     * Seed attendance records for the past 30 days
     */
    private function seedAttendance(array $users): void
    {
        $startDate = now()->subDays(30);
        
        foreach ($users as $user) {
            for ($i = 0; $i < 30; $i++) {
                $date = $startDate->copy()->addDays($i);
                
                // Skip weekends
                if ($date->isWeekend()) {
                    continue;
                }
                
                // Random chance of absence (10%)
                if (rand(1, 10) === 1) {
                    \App\Models\Attendance::create([
                        'user_id' => $user->id,
                        'date' => $date,
                        'status' => 'absent',
                        'notes' => 'No attendance recorded',
                    ]);
                    continue;
                }
                
                // Normal working day
                $checkIn = $date->copy()->setTime(8, 0)->addMinutes(rand(-15, 60)); // 7:45 AM to 9:00 AM
                $checkOut = $date->copy()->setTime(17, 0)->addMinutes(rand(-30, 60)); // 4:30 PM to 6:00 PM
                
                // Determine status based on check-in time
                $status = 'present';
                if ($checkIn->hour >= 9 || ($checkIn->hour === 8 && $checkIn->minute > 15)) {
                    $status = 'late';
                }
                
                \App\Models\Attendance::create([
                    'user_id' => $user->id,
                    'date' => $date,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                    'notes' => $status === 'late' ? 'Arrived late' : null,
                ]);
            }
        }
    }

    /**
     * Seed leave requests with various statuses
     */
    private function seedLeaveRequests(array $users, array $leaveTypes): void
    {
        $hrManager = $users[1]; // HR Manager for approvals
        $employees = array_slice($users, 2); // Only employees can request leave
        
        $leaveRequestsData = [
            // Pending requests
            [
                'user_id' => $employees[0]->id,
                'leave_type_id' => $leaveTypes[0]->id, // Annual Leave
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(12),
                'days' => 3,
                'reason' => 'Family vacation to Bali',
                'status' => 'pending',
            ],
            [
                'user_id' => $employees[1]->id,
                'leave_type_id' => $leaveTypes[1]->id, // Sick Leave
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(5),
                'days' => 1,
                'reason' => 'Medical checkup appointment',
                'status' => 'pending',
            ],
            [
                'user_id' => $employees[2]->id,
                'leave_type_id' => $leaveTypes[0]->id, // Annual Leave
                'start_date' => now()->addDays(15),
                'end_date' => now()->addDays(19),
                'days' => 5,
                'reason' => 'Wedding anniversary celebration',
                'status' => 'pending',
            ],
            
            // Approved requests
            [
                'user_id' => $employees[0]->id,
                'leave_type_id' => $leaveTypes[1]->id, // Sick Leave
                'start_date' => now()->subDays(5),
                'end_date' => now()->subDays(4),
                'days' => 2,
                'reason' => 'Flu and fever',
                'status' => 'approved',
                'approved_by' => $hrManager->id,
                'approved_at' => now()->subDays(6),
            ],
            [
                'user_id' => $employees[1]->id,
                'leave_type_id' => $leaveTypes[0]->id, // Annual Leave
                'start_date' => now()->subDays(15),
                'end_date' => now()->subDays(12),
                'days' => 4,
                'reason' => 'Family gathering in Surabaya',
                'status' => 'approved',
                'approved_by' => $hrManager->id,
                'approved_at' => now()->subDays(20),
            ],
            [
                'user_id' => $employees[2]->id,
                'leave_type_id' => $leaveTypes[2]->id, // Emergency Leave
                'start_date' => now()->subDays(8),
                'end_date' => now()->subDays(8),
                'days' => 1,
                'reason' => 'Family emergency',
                'status' => 'approved',
                'approved_by' => $hrManager->id,
                'approved_at' => now()->subDays(9),
            ],
            [
                'user_id' => $employees[3]->id,
                'leave_type_id' => $leaveTypes[0]->id, // Annual Leave
                'start_date' => now()->subDays(20),
                'end_date' => now()->subDays(18),
                'days' => 3,
                'reason' => 'Personal matters',
                'status' => 'approved',
                'approved_by' => $hrManager->id,
                'approved_at' => now()->subDays(25),
            ],
            
            // Rejected requests
            [
                'user_id' => $employees[0]->id,
                'leave_type_id' => $leaveTypes[0]->id, // Annual Leave
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(3),
                'days' => 6,
                'reason' => 'Extended vacation',
                'status' => 'rejected',
                'approved_by' => $hrManager->id,
                'approved_at' => now()->subDays(4),
                'rejection_reason' => 'Too many team members on leave during this period',
            ],
            [
                'user_id' => $employees[3]->id,
                'leave_type_id' => $leaveTypes[0]->id, // Annual Leave
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(6),
                'days' => 5,
                'reason' => 'Holiday trip',
                'status' => 'rejected',
                'approved_by' => $hrManager->id,
                'approved_at' => now()->subDays(12),
                'rejection_reason' => 'Insufficient notice period',
            ],
        ];
        
        foreach ($leaveRequestsData as $data) {
            \App\Models\LeaveRequest::create($data);
        }
    }

    /**
     * Seed payroll records for the last 3 months
     */
    private function seedPayroll(array $users): void
    {
        $months = [
            ['month' => 'October', 'year' => 2024],
            ['month' => 'November', 'year' => 2024],
            ['month' => 'December', 'year' => 2024],
        ];
        
        foreach ($users as $user) {
            // Get position salary range
            $position = \App\Models\Position::find($user->position_id);
            if (!$position) continue;
            
            foreach ($months as $index => $period) {
                // Calculate salary components
                $basicSalary = rand($position->min_salary, $position->max_salary);
                $allowances = $basicSalary * rand(10, 15) / 100; // 10-15% allowances
                $deductions = $basicSalary * rand(5, 10) / 100; // 5-10% deductions
                $bonus = ($index === 2) ? $basicSalary * rand(0, 20) / 100 : 0; // Bonus in December
                $netSalary = $basicSalary + $allowances + $bonus - $deductions;
                
                // Most recent month might be draft
                $status = ($index === 2 && rand(1, 3) === 1) ? 'draft' : 'paid';
                
                // Get month number for Carbon
                $monthNumber = (int) date('n', strtotime($period['month']));
                $paidAt = $status === 'paid' ? now()->setYear($period['year'])->setMonth($monthNumber)->endOfMonth() : null;
                
                \App\Models\Payroll::create([
                    'user_id' => $user->id,
                    'month' => $period['month'],
                    'year' => $period['year'],
                    'basic_salary' => $basicSalary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'bonus' => $bonus,
                    'net_salary' => $netSalary,
                    'status' => $status,
                    'paid_at' => $paidAt,
                ]);
            }
        }
    }

    /**
     * Seed performance reviews
     */
    private function seedPerformanceReviews(array $users): void
    {
        $reviewers = [$users[0], $users[1]]; // Admin and HR Manager as reviewers
        $employees = array_slice($users, 2); // Only review employees
        
        $reviewPeriods = ['Q3 2024', 'Q4 2024'];
        
        $strengthsPool = [
            'Excellent technical skills and problem-solving abilities',
            'Strong communication and teamwork',
            'Consistently meets deadlines and delivers quality work',
            'Proactive and takes initiative on projects',
            'Good attention to detail and accuracy',
            'Positive attitude and willingness to learn',
        ];
        
        $improvementPool = [
            'Could improve time management skills',
            'Needs to work on delegation and prioritization',
            'Should enhance technical documentation',
            'Could benefit from more proactive communication',
            'Needs to develop leadership skills',
            'Should focus on meeting deadlines more consistently',
        ];
        
        $goalsPool = [
            'Complete advanced certification in relevant technology',
            'Lead at least one major project in the next quarter',
            'Mentor junior team members',
            'Improve cross-functional collaboration',
            'Enhance technical skills in emerging technologies',
            'Develop better project management capabilities',
        ];
        
        foreach ($employees as $employee) {
            foreach ($reviewPeriods as $index => $period) {
                $reviewer = $reviewers[rand(0, 1)];
                
                // Generate realistic ratings (3-5 scale)
                $qualityOfWork = rand(3, 5);
                $productivity = rand(3, 5);
                $communication = rand(3, 5);
                $teamwork = rand(3, 5);
                $leadership = rand(2, 4); // Lower for non-management positions
                $overallRating = ($qualityOfWork + $productivity + $communication + $teamwork + $leadership) / 5;
                
                \App\Models\PerformanceReview::create([
                    'user_id' => $employee->id,
                    'reviewer_id' => $reviewer->id,
                    'review_period' => $period,
                    'quality_of_work' => $qualityOfWork,
                    'productivity' => $productivity,
                    'communication' => $communication,
                    'teamwork' => $teamwork,
                    'leadership' => $leadership,
                    'overall_rating' => round($overallRating, 2),
                    'strengths' => $strengthsPool[array_rand($strengthsPool)] . '. ' . $strengthsPool[array_rand($strengthsPool)],
                    'areas_for_improvement' => $improvementPool[array_rand($improvementPool)],
                    'goals' => $goalsPool[array_rand($goalsPool)] . '. ' . $goalsPool[array_rand($goalsPool)],
                    'comments' => $employee->name . ' has shown ' . ($overallRating >= 4 ? 'excellent' : 'good') . ' performance during ' . $period . '. Continue the good work and focus on the improvement areas mentioned above.',
                ]);
            }
        }
    }
}
