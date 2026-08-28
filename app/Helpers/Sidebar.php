<?php

use App\Models\M_dashboard;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;

function get_pengguna()
{
    $id     = auth()->user()->id;
    $global = new M_dashboard();
    $data   = $global->get_user($id);
    return $data;
}

function get_induk()
{
    $roles  = auth()->user()->id_roles;
    $data   = M_dashboard::get_induk($roles);
    return $data;
}

function get_parent()
{
    $roles  = auth()->user()->id_roles;
    $data = M_dashboard::get_parent($roles);
    return $data;
}

function get_child()
{
    $roles  = auth()->user()->id_roles;
    $data = M_dashboard::get_parent_child($roles);
    return $data;
}

function get_roles()
{
    $data = M_dashboard::get_roles();
    return $data;
}

function isMenuActive($public_id)
{
    return request()->is(trim($public_id, '/'));
}

function isLevelActive($item, $children) {
    return isMenuActive($item->public_id) || $children->contains(fn($child) => isMenuActive($child->public_id));
}

function isGrandLevelActive($item, $children) {
    return isMenuActive($item->public_id) || $children->contains(fn($child) => 
        isMenuActive($child->public_id) || get_child()->where('id_parent_child', $child->id)->contains(
            fn($grandchild) => isMenuActive($grandchild->public_id)
        )
    );
}