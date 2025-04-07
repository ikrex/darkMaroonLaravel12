@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tartalom kezelése</h1>
        <a href="{{ route('admin.content.create') }}" class="btn btn-maroon">Új tartalom hozzáadása</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kulcs</th>
                        <th>Cím</th>
                        <th>Aktív</th>
                        <th>Sorrend</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                        <tr>
                            <td>{{ $content->id }}</td>
                            <td>{{ $content->key }}</td>
                            <td>{{ $content->title }}</td>
                            <td>
                                @if($content->is_active)
                                    <span class="badge bg-success">Aktív</span>
                                @else
                                    <span class="badge bg-secondary">Inaktív</span>
                                @endif
                            </td>
                            <td>{{ $content->sort_order }}</td>
                            <td>
                                <a href="{{ route('admin.content.edit', $content->id) }}" class="btn btn-sm btn-primary">Szerkesztés</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
