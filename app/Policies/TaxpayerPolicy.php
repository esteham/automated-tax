<?php

namespace App\Policies;

use App\Models\Taxpayer;
use App\Models\User;

class TaxpayerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('filing.view') || $user->hasRole(['admin','auditor','accountant']);

    }//end methoad

    public function view(User $user, Taxpayer $taxpayer): bool
    {
        return $user->hasRole(['admin','auditor','accountant'])
            || $taxpayer->user_id === $user->id;

    }//end methoad

    public function create(User $user): bool
    {
        return $user->hasRole(['admin','accountant']) || $user->can('filing.create');

    }//end methoad

    public function update(User $user, Taxpayer $taxpayer): bool
    {
        return $user->hasRole(['admin','accountant']) || $taxpayer->user_id === $user->id;

    }//end methoad

    public function delete(User $user, Taxpayer $taxpayer): bool
    {
        return $user->hasRole('admin');

    }//end methoad

}
