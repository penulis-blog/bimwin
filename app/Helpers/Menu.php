<?php

use App\Models\M_dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function name_domain()
{
    $data = URL::to('/');
    return $data;
}

function get_detail($encode = null)
{
    $data = '<a href="javascript:;" onclick="Page.Detail(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"><span class="badge bg-dark"><i class="fa-solid fa-eye"></i></span></a> ';
    return $data;
}

function get_view()
{
    $roles      = auth()->user()->id_roles;
    $path       = url()->current();
    $cut_path   = str_replace('/json', '', str_replace(name_domain() . '/', '', $path));
    $how_id     = DB::table('sys_menu')->select('id_parent')->where([['public_id', '=', $cut_path]])->get();
    $data       = DB::table('view_permissions')->select('view')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['id', '=', $how_id[0]->id_parent]])->first('view');

    return $data->view;
}

function get_add()
{
    $roles      = auth()->user()->id_roles;
    $path       = url()->current();
    $cut_path   = str_replace('/json', '', str_replace(name_domain() . '/', '', $path));
    $bypass = [
        'b7256ae8-a040-4a3d-bea5-52cc443b69bc',
        '109c726c-d08c-4d11-a5d4-9d17819cd783',
        'eb4b303c-e0e8-4c08-9969-293dc870cfbf'
    ];

    if (in_array($cut_path, $bypass)) {
        return 1;
    }

    $data = DB::table('view_permissions')
        ->select('add')
        ->where('is_trash', 1)
        ->where('id_roles', $roles)
        ->where('public_id', $cut_path)
        ->first();

    return $data?->add ?? 0;
}

function get_laporan()
{
    $roles      = auth()->user()->id_roles;
    $path       = url()->current();
    $cut_path   = str_replace('/json', '', str_replace(name_domain() . '/', '', $path));
    $bypass = [
        'b7256ae8-a040-4a3d-bea5-52cc443b69bc',
        '109c726c-d08c-4d11-a5d4-9d17819cd783',
        'eb4b303c-e0e8-4c08-9969-293dc870cfbf'
    ];

    if (in_array($cut_path, $bypass)) {
        return 1;
    }

    $data       = DB::table('view_permissions')->select('report')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('report');
    return $data->report ?? 0;
}

function get_edit($encode, $roles, $path, $cut_path)
{
    $data = DB::table('view_permissions')->select('edit')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('edit');

    if ($data->edit == 1) {
        $button = '<a href="javascript:;" onclick="Page.Edit(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="badge bg-warning"><i class="fa fa-pencil"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_delete($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('delete')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('delete');

    if ($data->delete == 1) {
        $button = '<a href="javascript:;" onclick="Page.Delete(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><span class="badge bg-danger"><i class="fa fa-trash"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_password($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('password')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('password');

    if ($data->password == 1) {
        $button = '<a href="javascript:;" onclick="Page.Password(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Password"><span class="badge bg-info"><i class="fa fa-key"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_agree($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('agree')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('agree');

    if ($data->agree == 1) {
        $button = '<a href="javascript:;" onclick="Page.Agree(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Biodata"><span class="badge bg-success"><i class="fa fa-check"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_back($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('back')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('back');

    if ($data->back == 1) {
        $button = '<a href="javascript:;" onclick="Page.Back(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Formulir"><span class="badge bg-info"><i class="fa fa-barcode"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_config($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('config')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('config');

    if ($data->config == 1) {
        $button = '<a href="javascript:;" onclick="Page.Config(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Menu"><span class="badge bg-primary"><i class="fa fa-cogs"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_modules($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('module')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('module');

    if ($data->module == 1) {
        $button = '<a href="javascript:;" onclick="Page.Modules(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Modules"><span class="badge bg-info"><i class="fa fa-book"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}

function get_download($encode, $roles, $path, $cut_path)
{
    $data       = DB::table('view_permissions')->select('download')->where([['is_trash', '=', 1], ['id_roles', '=', $roles], ['public_id', '=', $cut_path]])->first('download');

    if ($data->download == 1) {
        $button = '<a href="javascript:;" onclick="Page.Download(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="Sertifikat"><span class="badge bg-primary"><i class="fa fa-download"></i></span></a> ';
    } else {
        $button = '';
    }
    return $button;
}