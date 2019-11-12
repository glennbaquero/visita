<?php

use Illuminate\Database\Seeder;

use App\Models\Permissions\PermissionCategory;
use App\Models\Permissions\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Sample Item Management',
                'description' => 'Manage Sample Items',
                'icon' => 'fa fa-cubes',
                'items' => [
                    [
                        'name' => 'admin.sample-items.crud',
                        'description' => 'Manage Sample Items',
                    ],
                ],
            ],
            [
                'name' => 'Content Management',
                'description' => 'Manage Pages & Contents',
                'icon' => 'fa fa-feather',
                'items' => [
                    [
                        'name' => 'admin.pages.crud',
                        'description' => 'Manage Pages',
                    ],
                    [
                        'name' => 'admin.page-items.crud',
                        'description' => 'Manage Page Contents',
                    ],
                    [
                        'name' => 'admin.articles.crud',
                        'description' => 'Manage Articles',
                    ],
                ],
            ],
            [
                'name' => 'Carousels',
                'description' => 'Manage Page Carousels',
                'icon' => 'fa fa-feather',
                'items' => [
                    [
                        'name' => 'admin.home-banners.crud',
                        'description' => 'Manage Carousels',
                    ],
                ],
            ],
            [
                'name' => 'Tabbings',
                'description' => 'Manage Tabbings',
                'icon' => 'fa fa-feather',
                'items' => [
                    [
                        'name' => 'admin.about-infos.crud',
                        'description' => 'Manage About Tabbings',
                    ],
                ],
            ],
            [
                'name' => 'Admin Management',
                'description' => 'Manage Administrators',
                'icon' => 'fa fa-user-shield',
                'items' => [
                    [
                        'name' => 'admin.admin-users.crud',
                        'description' => 'Manage Administrator Accounts',
                    ],
                    [
                        'name' => 'admin.roles.crud',
                        'description' => 'Manage Admin Roles & Permissions',
                    ],
                ],
            ],
            [
                'name' => 'User Management',
                'description' => 'Manage User Accounts',
                'icon' => 'fa fa-users',
                'items' => [
                    [
                        'name' => 'admin.users.crud',
                        'description' => 'Manage User Accounts',
                    ],
                ],
            ],
            [
                'name' => 'Activity Logs',
                'description' => 'View Activity Logs',
                'icon' => 'fa fa-shield-alt',
                'items' => [
                    [
                        'name' => 'admin.activity-logs.crud',
                        'description' => 'View Activity Logs',
                    ],
                ],
            ],

            [
                'name' => 'Allocations',
                'description' => 'Manage Allocations',
                'icon' => 'fas fa-hiking',
                'items' => [
                    [
                        'name' => 'admin.allocations.crud',
                        'description' => 'Manage Allocations',
                    ],
                ],
            ],
            [
                'name' => 'Destinations',
                'description' => 'Manage Destinations',
                'icon' => 'fas fa-map-marked-alt',
                'items' => [
                    [
                        'name' => 'admin.destinations.crud',
                        'description' => 'Manage Destinations',
                    ],
                ],
            ],
            [
                'name' => 'Experiences',
                'description' => 'Manage Experiences',
                'icon' => 'fas fa-hiking',
                'items' => [
                    [
                        'name' => 'admin.experiences.crud',
                        'description' => 'Manage Experiences',
                    ],
                ],
            ],

            [
                'name' => 'Inquiries',
                'description' => 'View Inquiries',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.inquiries.crud',
                        'description' => 'View Inquiries',
                    ],
                ],
            ],

            [
                'name' => 'Annual Incomes',
                'description' => 'Manage Annual Income',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.annual_incomes.crud',
                        'description' => 'Manage Annual Income',
                    ],
                ],
            ],

            [
                'name' => 'Survey Experiences',
                'description' => 'Manage Survey Experience',
                'icon' => 'fas fa-at',
                'items' => [
                    [
                        'name' => 'admin.survey_experiences.crud',
                        'description' => 'Manage Survey Experience',
                    ],
                ],
            ],
        ];

    	foreach ($categories as $category) {
            $permissions = $category['items'];
            unset($category['items']);

            $item = PermissionCategory::where('name', $category['name'])->first();

            if (!$item) {
                $this->command->info('Adding permission category ' . $category['name'] . '...');
                $item = PermissionCategory::create($category);
            } else {
                $this->command->warn('Updating permission category ' . $category['name'] . '...');
                $item->update($category);
            }


            foreach ($permissions as $permission) {
                $permissionItem = Permission::where('name', $permission['name'])->first();
                
                if (!$permissionItem) {
                    $this->command->info('Adding permission ' . $permission['name'] . '...');
                    $item->permissions()->create($permission);
                } else {
                    $this->command->warn('Updating permission ' . $permission['name'] . '...');
                    unset($permission['name']);
                    $permissionItem->update($permission);
                }
            }
    	}
    }
}
