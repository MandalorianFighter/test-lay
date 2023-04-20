<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\TagsDataTable;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(TagsDataTable $dataTable)
    {
        return $dataTable->render('users.tags');
    }

    public function dataTag(Request $request)
    {
        $model = Tag::query();
 
        return app('datatables')->eloquent($model)
        ->editColumn('tag_name', function ($model) {
            return '<a title="Follow The Link To Edit Tag" href="/users/tags/edit/'.$model->id.'">'.$model->tag_name.'</a>';
        })
        ->orderColumn('tag_name', function ($query, $order) {
            $query->orderBy('tag_name', $order);
        })
        ->editColumn('created_at', function ($model) {
            return [
               'display' => $model->created_at->diffForHumans(),
               'timestamp' => $model->created_at->timestamp
            ];
         })
        ->addIndexColumn()
        ->addColumn('action', function ($model) {
            return view('users.tags.delete', ['tag' => $model]);
        })
        ->rawColumns(['tag_name', 'action'])
        ->toJson();
    }

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

        $notification = array(
            'message' => 'Tag Is Updated Successfully!',
            'alert-type' => 'success',
        );

        return Redirect()->route('user.tags')->with($notification);
    }

    public function delete(Tag $tag)
    {
        if($tag->employees->count()) $tag->employees()->detach();
        $tag->delete();

        $notification = array(
            'message' => 'Tag Is Deleted!',
            'alert-type' => 'warning',
        );

        return Redirect()->route('user.tags')->with($notification);
    }
}
