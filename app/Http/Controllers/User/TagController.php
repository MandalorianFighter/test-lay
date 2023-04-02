<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{

    public function add()
    {    
        return view('users.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|min:2|max:256'
        ]);

        Tag::create([
            'tag_name' => $request->tag_name
        ]);

        $notification = array(
            'message' => 'Tag Is Created Successfully!',
            'alert-type' => 'success',
        );

        return Redirect()->route('user.tags')->with($notification);
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        
        return view('users.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tag_name' => 'required|min:2|max:256'
        ]);

        $tag = Tag::findOrFail($id);

        $tag->update([
            'tag_name' => $request->tag_name
        ]);

        $notification = array(
            'message' => 'Tag Is Updated Successfully!',
            'alert-type' => 'info',
        );

        return Redirect()->route('user.tags')->with($notification);
    }

    public function delete($id)
    {
        $department = Tag::find($id);
        $department->delete();

        $notification = array(
            'message' => 'Tag Is Deleted Successfully!',
            'alert-type' => 'warning',
        );

        return Redirect()->route('user.tags')->with($notification);
    }
}
