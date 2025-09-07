<x-dashboard-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your system.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Users -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <!-- Total Roles -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Roles</p>
                    <p class="text-2xl font-semibold">{{ $totalRoles }}</p>
                </div>
            </div>
        </div>

        <!-- Total Permissions -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                    <i class="fas fa-key"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Permissions</p>
                    <p class="text-2xl font-semibold">{{ $totalPermissions }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Recent Users</p>
                    <p class="text-2xl font-semibold">{{ $recentUsers->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h2 class="dashboard-card-title">Quick Actions</h2>
            </div>
            <div class="quick-actions">
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Add New User</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-tags"></i>
                    <span>Manage Roles</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-cog"></i>
                    <span>System Settings</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-chart-bar"></i>
                    <span>View Reports</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="mt-8">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h2 class="dashboard-card-title">Recent Users</h2>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Email</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Role</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Joined</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <div class="flex items-center justify-center w-10 h-10 text-white bg-blue-500 rounded-full">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $user->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
