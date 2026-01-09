@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827;">All Projects</h1>
    <a href="{{ route('admin.builder.create') }}" class="btn-primary" style="width: auto; padding: 0.75rem 2rem;">Create New Page</a>
</div>

<div class="glass" style="border-radius: var(--radius-lg); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: rgba(0,0,0,0.02); border-bottom: 1px solid rgba(0,0,0,0.05);">
                <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light);">Title</th>
                <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light);">Slug</th>
                <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light);">Public URL</th>
                <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light);">Last Updated</th>
                <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-light); text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: background 0.2s;">
                <td style="padding: 1rem 1.5rem; font-weight: 500;">
                    {{ $project->title }}
                </td>
                <td style="padding: 1rem 1.5rem; color: var(--text-light);">
                    {{ $project->slug }}
                </td>
                <td style="padding: 1rem 1.5rem;">
                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank" style="color: var(--primary-color); text-decoration: none;">View Live &nearr;</a>
                </td>
                <td style="padding: 1rem 1.5rem; color: var(--text-light);">
                    {{ $project->updated_at->diffForHumans() }}
                </td>
                <td style="padding: 1rem 1.5rem; text-align: right;">
                    <a href="{{ route('admin.builder.edit', $project->id) }}" style="color: var(--primary-color); text-decoration: none; margin-right: 1rem; font-weight: 500;">Edit</a>
                    
                    <form action="{{ route('admin.builder.destroy', $project->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this page?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; cursor: pointer;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($projects->isEmpty())
            <tr>
                <td colspan="5" style="padding: 3rem; text-align: center; color: var(--text-light);">
                    No projects found. <a href="{{ route('admin.builder.create') }}" style="color: var(--primary-color);">Create one now</a>.
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
