@extends('admin.layouts.app')
@section('title', 'Pages')
@section('breadcrumb', 'Pages')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">CMS Pages</h1>
  <a href="{{ route('admin.pages.create') }}" class="btn btn--primary">+ New Page</a>
</div>

<div class="admin-card">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Slug</th>
        <th>Status</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pages as $page)
        <tr>
          <td>
            <strong>{{ $page->title }}</strong>
            @if($page->short_description)
              <p style="font-size:12px;color:var(--clr-muted);margin-top:2px;">{{ Str::limit($page->short_description, 60) }}</p>
            @endif
          </td>
          <td>
            <code style="font-size:12px;background:var(--clr-bg);padding:2px 6px;border-radius:4px;">/page/{{ $page->slug }}</code>
          </td>
          <td>
            <span class="badge {{ $page->status === 'published' ? 'badge--active' : 'badge--inactive' }}">
              {{ ucfirst($page->status) }}
            </span>
          </td>
          <td>{{ $page->updated_at->format('d M Y') }}</td>
          <td class="admin-table__actions">
            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn--sm btn--outline" title="Preview">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="13" height="13"><path d="M9 3h4v4"/><path d="M13 3l-6 6"/><path d="M7 4H3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V9"/></svg>
            </a>
            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}"
                  onsubmit="return confirm('Delete page &quot;{{ addslashes($page->title) }}&quot;? This cannot be undone.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="admin-table__empty">No pages yet. <a href="{{ route('admin.pages.create') }}">Create one</a>.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="admin-pagination">{{ $pages->links() }}</div>
</div>
@endsection
