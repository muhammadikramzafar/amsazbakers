@extends('admin.layouts.app')
@section('title', 'Awards & Certifications')

@section('content')
<div class="admin-page">
  <div class="admin-page__header">
    <div>
      <h1 class="admin-page__title">Awards & Certifications</h1>
      <p class="admin-page__sub">{{ $awards->total() }} entries</p>
    </div>
    <a href="{{ route('admin.awards.create') }}" class="btn btn--primary">+ Add Award</a>
  </div>

  @if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width:60px;">Image</th>
          <th>Title</th>
          <th>Awarding Body</th>
          <th>Year</th>
          <th>Order</th>
          <th>Active</th>
          <th style="width:120px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($awards as $award)
        <tr>
          <td>
            @if($award->image_url)
              <img src="{{ $award->image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:6px;" />
            @else
              <div style="width:44px;height:44px;border-radius:6px;background:#f3e2c7;display:flex;align-items:center;justify-content:center;">🏆</div>
            @endif
          </td>
          <td><strong>{{ $award->title }}</strong></td>
          <td>{{ $award->awarding_body ?? '—' }}</td>
          <td>{{ $award->year ?? '—' }}</td>
          <td>{{ $award->sort_order }}</td>
          <td><span class="badge {{ $award->is_active ? 'badge--success':'badge--grey' }}">{{ $award->is_active ? 'Active':'Inactive' }}</span></td>
          <td class="admin-table__actions">
            <a href="{{ route('admin.awards.edit', $award) }}" class="btn btn--sm btn--outline">Edit</a>
            <form method="POST" action="{{ route('admin.awards.destroy', $award) }}" onsubmit="return confirm('Delete award?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn--sm btn--danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="admin-table__empty">No awards yet. <a href="{{ route('admin.awards.create') }}">Add one.</a></td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="admin-card__footer">{{ $awards->links() }}</div>
  </div>
</div>
@endsection
