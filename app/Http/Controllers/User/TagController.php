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

        return Redirect()->route('user.tags');
    }

    public function edit(Tag $tag)
    {
        return view('users.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tag_name' => 'required|min:2|max:256'
        ]);

        $tag->update([
            'tag_name' => $request->tag_name
        ]);

        return Redirect()->route('user.tags');
    }

    public function delete(Tag $tag)
    {
        if($tag->employees->count()) {
            $tag->employees->each(function ($employee) use ($tag) { 
                $tag->employees()->detach($employee);
            });
        }
        $tag->delete();
    }
}
