@extends('layouts.app')

@section('title', 'Projects List')


@section('content')
<h1 class="text-center mt-5">My Projects</h1>
@include('includes.alert')
<div class="d-flex justify-content-end mt-5">
    <a class="d-inline-block btn btn-secondary me-2" href="{{ route('admin.projects.trash') }}">Open Trash</a>
    <a class="d-inline-block btn btn-success" href="{{ route('admin.projects.create') }}">Add A Project</a>
</div>
    <ul class="list-unstyled">
        @forelse ($projects as $project)
            <li class="my-5">
                <div class="card p-5 bg-dark text-white">
                    <div class="card-header rounded border-0 mb-4 d-flex justify-content-between align-content-center ">
                        <h2 class="m-0 d-flex align-items-center">
                            {{ $project->title }}
                        </h2>
                        @if ($project->is_public)
                            <div class="alert alert-success m-0">
                                Open-Source
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="">
                            {{ $project->description }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between mt-3 align-items-center border-0 bg-dark">
                        <div>
                            Created: {{ $project->created_at }} <br>
                            Last Modified at: {{ $project->updated_at }}
                        </div>
                        <div class="buttons d-flex">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>More details
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning mx-2">
                                <i class="fas fa-pen me-2"></i>Edit
                                project
                            </a>
                            <form class="delete-form" action="{{ route('admin.projects.destroy', $project) }}"
                                method="POST" data-name="{{ $project->title }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete project
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
            </li>
        @empty
        <h4 class="alert alert-danger mt-5 text-white">No Projects Found</h4>
        @endforelse
    </ul>
    @if ($projects->hasPages())
        {{ $projects->links() }}
    @endif
@endsection
@section('scripts')
    @vite('resources/js/delete-confirm.js');
@endsection