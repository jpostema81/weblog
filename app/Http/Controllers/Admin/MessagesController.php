<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MessageResource;
use App\Http\Requests\StoreMessage;


class MessagesController extends Controller
{
    /**
     * Register Auth middleware for this controller so only authenticated users can access these controller functions
     * Register Clearance middleware which is responsible for the ACL (permissions and roles system)
     */
    public function __construct() {
        $this->middleware(['auth', 'clearance']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $messages = Message::orderBy('created_ad', 'desc')->where('author_id', $userId);

        // apply keyword filter
        if($request->has('keyword')) {
            $messages->where('title', 'like', '%' . $request->get('keyword') . '%');
        }

        return MessageResource::collection($messages->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessage $request)
    {   
        // Validate input and retrieve fields    
        $validatedInput = $request->validated();
        $userId = Auth::user()->id;

        // create new message and store it
        $message = new Message();
        $message->fill($validatedInput);
        $message->author_id = $userId;

        if($request->hasFile('image')) {
            $filename = $request->file('image')->store('public'); // store function generates unique ID to serve as filename
            $message->image = basename($filename);
        }
        
        $message->save();

        if($request->has('categories') && $request->categories !== null) 
        {
            $catgory_ids = array_map('intval', explode(',', $request->categories));
            $message->categories()->sync($catgory_ids);
        }

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMessage $request, Message $message)
    {
        // Validate input and retrieve fields    
        $validatedInput = $request->validated();
        $userId = Auth::user()->id;

        // remove previous image if available
        $result = Storage::delete('public/'.$message->image);

        // update message with new data
        $userId = Auth::user()->id;

        $message->fill($validatedInput);
        $message->author_id = $userId;

        if($request->has('categories') && $request->categories !== null) 
        {
            $catgory_ids = array_map('intval', explode(',', $request->categories));
            $message->categories()->sync($catgory_ids);
        }

        if($request->hasFile('image')) {
            $filename = $request->file('image')->store('public'); // store function generates unique ID to serve as filename
            $message->image = basename($filename);
        }

        $result = $message->save();

        return response()->json($message);
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

        if($result) 
        {
            return response()->json([
                'message' => 'deletion of message succeeded'
            ]);
        } 
        else 
        {
            return response()->json([
                'message' => 'deletion of message failed'
            ]);
        }
    }
}
