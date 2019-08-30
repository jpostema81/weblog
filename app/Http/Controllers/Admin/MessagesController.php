<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MessagesController extends Controller
{
    /**
     * Register Auth middleware for this controller
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $messages = Message::orderBy('created_ad', 'desc')->where('author_id', $userId)->get();

        return view('admin.messages.index', ['messages' => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $message = new Message();
        return view('admin.messages.form', compact('message'));
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

        $message = new Message();
        $message->title = Input::get('title');
        $message->content = Input::get('content');
        $message->author_id = $userId;
        $message->save();

        $message->categories()->attach($request->get('categories'));

        return redirect()->route('admin.messages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        return view('admin.messages.form', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        // validate user input
        $validatedData = $request->validate($this->rules());

        // update message with new data
        $userId = Auth::user()->id;

        $message->title = Input::get('title');
        $message->content = Input::get('content');
        $message->author_id = $userId;
        $message->categories()->sync($request->get('categories'));
        $message->save();

        return redirect()->route('admin.messages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $result = $message->delete();

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
            'title' => 'required|max:255',
            'content' => 'required',
        ];

        //'title' => 'required|unique:messages|max:255',
    }
}
