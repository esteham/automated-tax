<!DOCTYPE html>
<html>
<head>
    <title>Test Blade Directives</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Blade Directives Test</h1>
        
        <div class="space-y-4">
            <div class="p-4 border rounded">
                <h2 class="font-semibold mb-2">@role('admin') Directive Test</h2>
                @role('admin')
                    <div class="text-green-600">✅ You have the admin role</div>
                @else
                    <div class="text-red-600">❌ You don't have the admin role</div>
                @endrole
            </div>

            <div class="p-4 border rounded">
                <h2 class="font-semibold mb-2">@can('filing.create') Directive Test</h2>
                @can('filing.create')
                    <div class="text-green-600">✅ You have permission to create filings</div>
                @else
                    <div class="text-red-600">❌ You don't have permission to create filings</div>
                @endcan
            </div>

            <div class="p-4 border rounded">
                <h2 class="font-semibold mb-2">User Information</h2>
                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Roles:</strong> {{ auth()->user()->getRoleNames()->implode(', ') }}</p>
                <p><strong>Permissions:</strong> {{ auth()->user()->getAllPermissions()->pluck('name')->implode(', ') }}</p>
            </div>

            <div class="p-4 border rounded">
                <h2 class="font-semibold mb-2">Available Routes</h2>
                <ul class="list-disc pl-5 space-y-1">
                    <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    @if(auth()->user()->hasRole('admin'))
                        <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Admin Dashboard</a></li>
                    @endif
                    @if(auth()->user()->hasRole('accountant'))
                        <li><a href="{{ route('accountant.dashboard') }}" class="text-blue-600 hover:underline">Accountant Dashboard</a></li>
                    @endif
                    @if(auth()->user()->hasRole('auditor'))
                        <li><a href="{{ route('auditor.dashboard') }}" class="text-blue-600 hover:underline">Auditor Dashboard</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
