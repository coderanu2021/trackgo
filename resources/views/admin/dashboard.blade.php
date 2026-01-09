@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Dashboard</h1>
        <p style="color: #6b7280;">Welcome to your custom website builder.</p>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="glass" style="padding: 1.5rem; border-radius: var(--radius-md);">
            <div style="font-size: 0.875rem; color: var(--text-light); margin-bottom: 0.5rem;">Total Projects</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-color);">{{ $projects->count() }}</div>
        </div>
        <div class="glass" style="padding: 1.5rem; border-radius: var(--radius-md);">
            <div style="font-size: 0.875rem; color: var(--text-light); margin-bottom: 0.5rem;">Published Pages</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-color);">8</div>
        </div>
        <div class="glass" style="padding: 1.5rem; border-radius: var(--radius-md);">
            <div style="font-size: 0.875rem; color: var(--text-light); margin-bottom: 0.5rem;">Total Views</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-color);">1,234</div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="glass" style="padding: 1.5rem; border-radius: var(--radius-md);">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Recent Projects</h2>
        
        @if($projects->count() > 0)
            <div style="display: grid; gap: 1rem;">
                @foreach($projects as $project)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(255,255,255,0.5); border-radius: var(--radius-md);">
                        <div>
                            <div style="font-weight: 600;">{{ $project->title }}</div>
                            <div style="font-size: 0.875rem; color: var(--text-light);">{{ url('projects/'.$project->slug) }}</div>
                        </div>
                        <a href="{{ route('projects.show', $project->slug) }}" target="_blank" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">View Page &rarr;</a>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 1.5rem; text-align: right;">
                <a href="{{ route('admin.builder.create') }}" class="btn-primary" style="display: inline-block; width: auto;">Create New</a>
            </div>
        @else
            <div style="border: 1px dashed #d1d5db; padding: 2rem; text-align: center; color: #6b7280; border-radius: var(--radius-md);">
                <p>No projects created yet.</p>
                <a href="{{ route('admin.builder.create') }}" style="color: var(--primary-color); font-weight: 500; text-decoration: none; margin-top: 0.5rem; display: inline-block;">Create your first project &rarr;</a>
            </div>
        @endif
    </div>
@endsection
