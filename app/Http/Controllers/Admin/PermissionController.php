<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;

// Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;


class PermissionController extends Controller
{
    public function __construct() {
        // isAdmin middleware lets only users with a //specific permission permission to access these resources
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all permissions
        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all roles
        $roles = Role::get();

        return view('admin.permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
        ]);

        $name = $request->get('name');
        $permission = new Permission();
        $permission->name = $name;
        $permission->save();

        // If one or more role is selected
        if (!empty($request->get('roles')))
        {
            $roles = $request->get('roles');

            foreach ($roles as $roleId) 
            {
                // Match input role to db record
                $r = Role::findOrFail($roleId); 

                // Match input //permission to db record
                // kan onderstaande regel code efficienter? bijv. $permission uit bovenstaande $permission halen?
                // hoeft $permission->name niet uniek te zijn?
                $permission = Permission::where('name', '=', $name)->first(); 
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('admin.permissions.index')->with('flash_message', 'Permission' . $permission->name . ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin.permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.create', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->route('permissions.index')->with('flash_message', 'Permission' . $permission->name . ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        // Make it impossible to delete this specific permission    
        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('permissions.index')->with('flash_message', 'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('flash_message', 'Permission deleted!');
    }
}
