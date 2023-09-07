<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('updated_at', 'DESC')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        return view('admin.projects.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|unique:projects',
                'image' => 'image:jpg,jpeg,png|nullable',
                'description' => 'string|nullable',
                'main_lang' => 'string|nullable',
                'other_langs' => 'string|nullable',
                'n_stars' => 'numeric|nullable|gt:0',
                'is_public' => 'boolean|nullable'
            ],
            [
                'title.required' => 'The title of the project is required',
                'title.unique' => 'The title alredy exists, must be unique',
                'n_stars.numeric' => 'You must insert a positive number',
                'image.url' => 'The file type is not valid',
            ]
        );

        $data = $request->all();
        $project = new Project($data);

        if (array_key_exists('image', $data)) {
            $ext = $data['image']->extension();
            $img_url = Storage::putFileAs('project_images', $data['image'], "{$data['slug']}.$ext");
            $data['image'] = $img_url;
        }


        $project->slug = Str::slug($project->title, '-');
        $project->fill($data);
        $project->save();

        return to_route('admin.projects.show', $project)->with('alert-message', "Project '$project->title' created successfully")->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');

        if (array_key_exists('image', $data)) {
            if ($project->image) Storage::delete($project->image);
            $ext = $data['image']->extension();
            $img_url = Storage::putFileAs('project_images', $data['image'], "{$data['slug']}.$ext");
            $data['image'] = $img_url;
        }

        $project->update($data);

        return to_route('admin.projects.show', $project)->with('alert-message', "Project '$project->title' edited successfully")->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('admin.projects.index')->with('alert-message', "Project '$project->title' moved to trash successfully")->with('alert-type', 'success');
    }

    public function trash()
    {
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }

    public function dropAll()
    {
        Project::onlyTrashed()->forceDelete();
        return to_route('admin.projects.trash')->with('alert-message', "All projects in the trash deleted successfully")->with('alert-type', 'success');
    }

    public function drop(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        if (!$project) return to_route('admin.projects.index')->with('alert-message', "Project not found")->with('alert-type', 'danger');

        if ($project->image) Storage::delete($project->image);


        $project->forceDelete();
        return to_route('admin.projects.trash')->with('alert-message', "Project '$project->title' deleted successfully")->with('alert-type', 'success');
    }


    public function restore(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $project->restore();

        return to_route('admin.projects.trash')->with('alert-message', "Project '$project->title' restored successfully")->with('alert-type', 'success');
    }
}
