@extends('layouts.app')
@section('title', "$project->title")
@section('content')
@include('includes.alert')
    <div class="card mt-5 bg-dark p-5 text-white">
        <div class="card-header rounded border-0 mb-4 d-flex justify-content-between align-content-center ">
            <h2 class="m-0 d-flex align-items-center">
                {{ $project->title }}
            </h2>
            @if ($project->is_public)
                <div class="alert alert-success m-0">
                    Open-source
                </div>
            @endif
        </div>
        <div class="card-body d-flex">
            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            <div class="ms-5">
                <p>
                    {{ $project->description }}
                </p>
                <ul>
                    <li>
                        <strong>Category:</strong> {{ $project->category ? $project->category->label : 'Not Available' }}
                    </li>
                    <li>
                        Main Language: {{ $project->main_lang }}
                    </li>
                    <li>
                        Other Languages: {{ $project->other_langs }}
                    </li>
                    <li>
                        Stars: {{ $project->n_stars }} <i class="fas fa-star"></i>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between mt-3 align-items-center border-0 bg-dark">
            <div class="buttons d-flex">
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning mx-2">
                    <i class="fas fa-pen me-2"></i>Edit
                    project
                </a>
                <form class="delete-form" action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                    data-name="{{ $project->title }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete project
                    </button>
                </form>
            </div>
            <div class="text-end">
                <strong>Created:</strong> {{ $project->created_at }} <br>
                <strong>Last Modified at:</strong> {{ $project->updated_at }}
            </div>
        </div>
    </div>
    <footer class="text-center">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mx-2 mt-5">Go back to the projects list</a>
    </footer>
@endsection
@section('scripts')
    @vite('resources/js/delete-confirm.js');
@endsection
