<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;

// Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Controller;

use Session;

class RoleController extends Controller
{
    public function __construct() 
    {
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
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new Role();
        $permissions = Permission::all();

        return view('admin.roles.create', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate name and permissions field
        $this->validate($request, [
            'name' => 'required|unique:roles|max:10',
            'permissions' => 'required',
        ]);

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();

        // Looping thru selected permissions
        foreach ($permissions as $permission) 
        {
            $p = Permission::where('id', '=', $permission)->firstOrFail();

            // Fetch the newly created role and assign permission
            // onderstaande query lijkt overbodig want name is al unique in de roles table?
            $role = Role::where('name', '=', $name)->first(); 
            $role->givePermissionTo($p);
        }
        

        return redirect()->route('admin.roles.index')->with('flash_message', 'Role'. $role->name.' added!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.create', compact('role', 'permissions'));
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
        // Get role with the given id
        $role = Role::findOrFail($id);

        // Validate name and permission fields
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();

        foreach($p_all as $p) 
        {
            // Remove all permissions associated with role
            $role->revokePermissionTo($p); 
        }

        foreach($permissions as $permission) 
        {
            // Get corresponding form //permission in db
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            // Assign permission to role
            $role->givePermissionTo($p);  
        }

        return redirect()->route('admin.roles.index')->with('flash_message', 'Role'. $role->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $result = $role->delete();

        if($result) {
            $data = [
                'status' => '1',
                'message' => 'Success'
            ];
        } else {
            $data = [
                'status' => '0',
                'message' => 'Fail'
            ];
        }

        return response()->json($data);
    }
}
