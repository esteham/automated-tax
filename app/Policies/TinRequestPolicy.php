<?php

namespace App\Policies;

use App\Models\TinRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TinRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Any authenticated user can view their own TIN requests
        // Admins and auditors can view all TIN requests
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TinRequest $tinRequest): bool
    {
        // Users can view their own TIN requests
        // Admins and auditors can view any TIN request
        return $user->id === $tinRequest->user_id || 
               $user->hasRole(['admin', 'auditor']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a TIN request
        // Check if user already has a pending or approved TIN request
        $existingRequest = TinRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
            
        return !$existingRequest;
    }

    /**
     * Determine whether the user can update the model.
     * Used for approving/rejecting TIN requests
     */
    public function update(User $user, TinRequest $tinRequest): bool
    {
        // Only admins and auditors can approve/reject TIN requests
        // And only if the request is still pending
        return $tinRequest->isPending() && 
               $user->hasRole(['admin', 'auditor']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TinRequest $tinRequest): bool
    {
        // Users can delete their own pending requests
        // Admins can delete any pending request
        return $tinRequest->isPending() && 
               ($user->id === $tinRequest->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TinRequest $tinRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TinRequest $tinRequest): bool
    {
        return false;
    }
}
