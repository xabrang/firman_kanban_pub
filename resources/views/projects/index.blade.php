@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-start">
                            <h4 class="m-0 p-0">{{ __('Proyek') }}</h4>
                            <a class="btn btn-primary ms-auto" href="{{ route('dashboard.projects.create') }}">Proyek baru</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="container text-center">
                            <div class="row row-cols-4">
                                @foreach ($projects as $project)
                                    <div class="col">
                                        <a href="{{ route('dashboard.projects.show', $project->id) }}"
                                            style="text-decoration: none">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3>{{ $project->name }}</h3>
                                                    <p>{{ $project->description }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
