<?php

namespace App\Policies;

use App\User;
use App\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the admin.
     *
     * @param  \App\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function isSuper()
    {
    	$admin = Auth::guard('admin')->user();

        return $admin->permission == 1;
        
    }
    
    public function isAdmin(Admin $admin)
    {
    	$admin = Auth::guard('admin')->user();

        return $admin->permission > 0 && $admin->permission < 3;
        
    }
    
    public function isDesigner()
    {
    	$admin = Auth::guard('admin')->user();

        return $admin->permission == 3;
        
    }
     
     
    public function view(User $user, Admin $admin)
    {
        
    }

    /**
     * Determine whether the user can create admins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the admin.
     *
     * @param  \App\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function update(User $user, Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can delete the admin.
     *
     * @param  \App\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function delete(User $user, Admin $admin)
    {
        //
    }
}
