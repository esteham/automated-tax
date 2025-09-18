@extends('layouts.app')

@section('content')
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

        <!-- Total TIN Requests -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total TIN Requests</p>
                    <p class="text-2xl font-semibold">{{ $totalTinRequests }}</p>
                </div>
            </div>
        </div>

        <!-- Pending TIN Requests -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 {{ $pendingTinRequests > 0 ? 'text-yellow-500 bg-yellow-100' : 'text-gray-500 bg-gray-100' }} rounded-full">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending TIN Requests</p>
                    <p class="text-2xl font-semibold">{{ $pendingTinRequests }}</p>
                </div>
            </div>
        </div>

        <!-- Approved TIN Requests -->
        <div class="dashboard-card">
            <div class="flex items-center">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Approved TINs</p>
                    <p class="text-2xl font-semibold">{{ $approvedTinRequests }}</p>
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
                <a href="{{ route('admin.tin-requests.index') }}" class="quick-action-btn">
                    <i class="fas fa-file-alt"></i>
                    <span>Manage TIN Requests</span>
                    @if($pendingTinRequests > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                            {{ $pendingTinRequests }}
                        </span>
                    @endif
                </a>
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
            </div>
        </div>
    </div>

    <!-- Recent TIN Requests -->
    <div class="mt-8">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h2 class="dashboard-card-title">Recent TIN Requests</h2>
                <a href="{{ route('admin.tin-requests.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Request ID</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Applicant</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentTinRequests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $request->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-10 h-10 rounded-full" 
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($request->full_name) }}&color=7F9CF5&background=EBF4FF" 
                                                 alt="{{ $request->full_name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $request->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($request->status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($request->status === 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $request->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.tin-requests.show', $request) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                    @can('delete', $request)
                                        <form action="{{ route('admin.tin-requests.destroy', $request) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                                    onclick="return confirm('Are you sure you want to delete this request?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No TIN requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
