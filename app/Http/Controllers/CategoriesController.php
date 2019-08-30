<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class CategoriesController extends Controller
{
    /**
     * Register Auth middleware for this controller
     */
    public function __contruct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Return all categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategories()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('categories.form', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate user input
        $validatedData = $request->validate($this->rules());

        // create new message and store it
        $userId = Auth::user()->id;

        $category = new Category();
        $category->name = Input::get('name');
        $category->save();

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.form', compact('category'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $result = $category->delete();

        if($result) {
            $data=[
                'status' => '1',
                'msg' => 'success'
              ];
        } else {
            $data=[
                'status' => '0',
                'msg' => 'fail'
              ];
        }
        
        return response()->json($data);
    }

    /**
     * Validate form user input
     */
    public function rules() {
        return [
            'name' => 'required|max:255',
        ];
    }
}
