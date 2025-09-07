<?php

namespace App\Policies;

use App\Models\TaxReturn;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxReturnPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_tax_return');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaxReturn $taxReturn): bool
    {
        // Users can only view their own tax returns
        return $user->id === $taxReturn->taxpayer->user_id || 
               $user->can('view_tax_return');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_tax_return');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaxReturn $taxReturn): bool
    {
        // Users can only update their own draft returns
        return ($user->id === $taxReturn->taxpayer->user_id && $taxReturn->status === 'draft') || 
               $user->can('update_tax_return');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaxReturn $taxReturn): bool
    {
        // Only draft returns can be deleted
        return ($user->id === $taxReturn->taxpayer->user_id && $taxReturn->status === 'draft') || 
               $user->can('delete_tax_return');
    }

    /**
     * Determine whether the user can submit the tax return.
     */
    public function submit(User $user, TaxReturn $taxReturn): bool
    {
        // Only the owner can submit, and only if it's a draft
        return $user->id === $taxReturn->taxpayer->user_id && 
               $taxReturn->status === 'draft';
    }

    /**
     * Determine whether the user can pay the tax.
     */
    public function pay(User $user, TaxReturn $taxReturn): bool
    {
        // Only the owner can pay, and only if it's submitted and not fully paid
        return $user->id === $taxReturn->taxpayer->user_id && 
               $taxReturn->status === 'submitted' && 
               $taxReturn->tax_amount > $taxReturn->paid_amount;
    }
}
