@extends('admin.layouts.app')
@section('title', 'Media Library')
@section('breadcrumb', 'Media Library')

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">Media Library</h1>
  <button class="btn btn--primary" id="openUploadBtn">+ Upload Files</button>
</div>

{{-- ── Upload panel ──────────────────────────────────────────── --}}
<div class="media-upload-panel" id="uploadPanel" style="display:none;">
  <div class="admin-card" style="margin-bottom:20px;">
    <div class="media-upload-header">
      <h3 class="admin-card__title">Upload Files</h3>
      <button type="button" class="btn btn--sm btn--outline" id="closeUploadBtn">Close</button>
    </div>

    <div class="form-group" style="margin-top:12px;">
      <label class="form-label" for="uploadFolder">Folder</label>
      <select class="form-control" id="uploadFolder" style="max-width:220px;">
        @foreach($folders as $folder)
          <option value="{{ $folder }}">{{ ucfirst($folder) }}</option>
        @endforeach
      </select>
    </div>

    <div class="drop-zone" id="dropZone">
      <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" width="40" height="40" style="color:var(--clr-muted);" aria-hidden="true">
        <path d="M24 32V16M17 23l7-7 7 7"/>
        <rect x="4" y="4" width="40" height="40" rx="4"/>
      </svg>
      <p class="drop-zone__text">Drag &amp; drop files here, or <label for="fileInput" class="drop-zone__browse">browse</label></p>
      <p class="drop-zone__hint">Supported: JPG, PNG, WEBP, PDF — max 10 MB each</p>
      <input type="file" id="fileInput" multiple
             accept=".jpg,.jpeg,.png,.webp,.pdf" style="display:none;" />
    </div>

    <div id="uploadProgress" style="margin-top:12px;"></div>
  </div>
</div>

{{-- ── Filter toolbar ────────────────────────────────────────── --}}
<div class="media-toolbar admin-card" style="padding:12px 16px; margin-bottom:16px;">
  <div class="media-folders">
    <a href="{{ route('admin.media.index') }}"
       class="folder-btn {{ !request('folder') ? 'folder-btn--active' : '' }}">All</a>
    @foreach($folders as $folder)
      <a href="{{ route('admin.media.index', ['folder' => $folder, 'search' => request('search')]) }}"
         class="folder-btn {{ request('folder') === $folder ? 'folder-btn--active' : '' }}">
        {{ ucfirst($folder) }}
      </a>
    @endforeach
  </div>

  <form method="GET" action="{{ route('admin.media.index') }}" class="media-search-form">
    @if(request('folder'))
      <input type="hidden" name="folder" value="{{ request('folder') }}" />
    @endif
    <input class="form-control" type="search" name="search"
           value="{{ request('search') }}"
           placeholder="Search files…" style="max-width:240px;" />
    <button type="submit" class="btn btn--outline btn--sm">Search</button>
  </form>
</div>

{{-- ── File grid ─────────────────────────────────────────────── --}}
@if($media->total())
  <p class="media-count">{{ number_format($media->total()) }} file{{ $media->total() !== 1 ? 's' : '' }}</p>
@endif

<div class="media-grid" id="mediaGrid">
  @forelse($media as $file)
    <div class="media-card" id="media-card-{{ $file->id }}">
      <div class="media-card__thumb">
        @if($file->is_image)
          <img src="{{ $file->url }}" alt="{{ $file->original_name }}" loading="lazy" />
        @elseif($file->extension === 'pdf')
          <div class="media-card__icon media-card__icon--pdf">PDF</div>
        @else
          <div class="media-card__icon">{{ strtoupper($file->extension) }}</div>
        @endif
      </div>

      <div class="media-card__body">
        <p class="media-card__name" title="{{ $file->original_name }}">
          {{ Str::limit($file->original_name, 22) }}
        </p>
        <p class="media-card__meta">
          {{ strtoupper($file->extension) }}
          @if($file->width) · {{ $file->width }}×{{ $file->height }} @endif
          · {{ $file->size_formatted }}
        </p>
      </div>

      <div class="media-card__actions">
        <button type="button" class="media-btn media-btn--copy"
                data-url="{{ $file->url }}" title="Copy URL">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14">
            <rect x="4" y="4" width="10" height="10" rx="1"/>
            <path d="M2 12V2h10"/>
          </svg>
        </button>
        <form method="POST" action="{{ route('admin.media.destroy', $file->id) }}"
              onsubmit="return confirm('Delete {{ addslashes($file->original_name) }}?')"
              id="del-{{ $file->id }}">
          @csrf @method('DELETE')
          <button type="submit" class="media-btn media-btn--del" title="Delete">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14">
              <path d="M2 4h12M6 4V2h4v2M5 4l1 10h4l1-10"/>
            </svg>
          </button>
        </form>
      </div>

      {{-- Copy tooltip --}}
      <span class="media-card__copied" id="copied-{{ $file->id }}" aria-live="polite">Copied!</span>
    </div>
  @empty
    <div class="media-empty">
      <p>No files found{{ request('search') ? ' matching "' . e(request('search')) . '"' : '' }}.</p>
      @if(!request('search'))
        <button class="btn btn--primary" id="emptyUploadBtn" style="margin-top:12px;">Upload your first file</button>
      @endif
    </div>
  @endforelse
</div>

{{-- Dynamically uploaded cards appear here --}}
<div id="newlyUploaded"></div>

<div class="admin-pagination" style="margin-top:16px;">{{ $media->withQueryString()->links() }}</div>

@endsection

@push('styles')
<style>
  /* Toolbar */
  .media-toolbar  { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
  .media-folders  { display:flex; flex-wrap:wrap; gap:6px; }
  .folder-btn     { padding:5px 14px; border-radius:100px; font-size:12px; font-weight:600; text-decoration:none; color:var(--clr-muted); background:var(--clr-bg); border:1px solid var(--clr-border); transition:all .15s; }
  .folder-btn--active { background:var(--clr-gold); color:#fff; border-color:var(--clr-gold); }
  .folder-btn:hover:not(.folder-btn--active) { border-color:var(--clr-brown); color:var(--clr-brown); }
  .media-search-form { display:flex; gap:6px; }
  .media-count { font-size:13px; color:var(--clr-muted); margin-bottom:12px; }

  /* Upload panel */
  .media-upload-header { display:flex; align-items:center; justify-content:space-between; }
  .drop-zone {
    border:2px dashed var(--clr-border); border-radius:var(--radius);
    padding:40px 24px; text-align:center; cursor:pointer;
    transition:border-color .15s, background .15s; margin-top:10px;
  }
  .drop-zone.drag-over { border-color:var(--clr-gold); background:#fffbf0; }
  .drop-zone__text  { margin-top:12px; font-size:14px; }
  .drop-zone__browse{ color:var(--clr-gold); text-decoration:underline; cursor:pointer; }
  .drop-zone__hint  { font-size:12px; color:var(--clr-muted); margin-top:4px; }

  /* Progress */
  .upload-item { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid var(--clr-border); font-size:13px; }
  .upload-item__status { margin-left:auto; font-weight:600; }
  .upload-item__status--ok  { color:var(--clr-success); }
  .upload-item__status--err { color:var(--clr-danger); }

  /* Grid */
  .media-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:14px; }
  .media-card {
    background:var(--clr-card); border:1px solid var(--clr-border);
    border-radius:var(--radius); overflow:hidden;
    transition:box-shadow .15s; position:relative;
  }
  .media-card:hover { box-shadow:0 4px 12px rgba(0,0,0,.1); }

  .media-card__thumb {
    width:100%; padding-top:66%; position:relative;
    background:var(--clr-bg); overflow:hidden;
  }
  .media-card__thumb img {
    position:absolute; inset:0; width:100%; height:100%; object-fit:cover;
  }
  .media-card__icon {
    position:absolute; inset:0;
    display:flex; align-items:center; justify-content:center;
    font-size:20px; font-weight:700; color:var(--clr-muted);
  }
  .media-card__icon--pdf { color:#dc2626; }

  .media-card__body { padding:8px 10px 4px; }
  .media-card__name { font-size:12px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .media-card__meta { font-size:11px; color:var(--clr-muted); margin-top:2px; }

  .media-card__actions {
    display:flex; gap:4px; padding:6px 10px 8px;
    opacity:0; transition:opacity .15s;
  }
  .media-card:hover .media-card__actions { opacity:1; }

  .media-btn {
    background:none; border:1px solid var(--clr-border); border-radius:4px;
    padding:5px; cursor:pointer; color:var(--clr-muted);
    display:inline-flex; align-items:center; justify-content:center;
    transition:all .15s;
  }
  .media-btn--copy:hover { border-color:var(--clr-gold); color:var(--clr-gold); }
  .media-btn--del:hover  { border-color:var(--clr-danger); color:var(--clr-danger); }

  .media-card__copied {
    position:absolute; top:8px; left:50%; transform:translateX(-50%);
    background:rgba(0,0,0,.75); color:#fff; font-size:11px; font-weight:600;
    padding:3px 8px; border-radius:4px; white-space:nowrap;
    opacity:0; pointer-events:none; transition:opacity .2s;
  }
  .media-card__copied.show { opacity:1; }

  .media-empty { grid-column:1/-1; text-align:center; padding:60px 24px; color:var(--clr-muted); }
</style>
@endpush

@push('scripts')
<script>
(function () {
  const uploadPanel   = document.getElementById('uploadPanel');
  const openBtn       = document.getElementById('openUploadBtn');
  const closeBtn      = document.getElementById('closeUploadBtn');
  const emptyBtn      = document.getElementById('emptyUploadBtn');
  const dropZone      = document.getElementById('dropZone');
  const fileInput     = document.getElementById('fileInput');
  const folderSel     = document.getElementById('uploadFolder');
  const progressBox   = document.getElementById('uploadProgress');
  const newlyUpd      = document.getElementById('newlyUploaded');
  const csrfToken     = document.querySelector('meta[name="csrf-token"]').content;

  function openPanel() { uploadPanel.style.display = 'block'; uploadPanel.scrollIntoView({behavior:'smooth'}); }
  openBtn.addEventListener('click', openPanel);
  if (emptyBtn) emptyBtn.addEventListener('click', openPanel);
  closeBtn.addEventListener('click', () => { uploadPanel.style.display = 'none'; });

  // Drag & drop
  dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
  dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
  dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    uploadFiles(e.dataTransfer.files);
  });
  dropZone.addEventListener('click', () => fileInput.click());
  fileInput.addEventListener('change', () => uploadFiles(fileInput.files));

  async function uploadFiles(files) {
    for (const file of files) {
      const row    = document.createElement('div');
      row.className = 'upload-item';
      row.innerHTML = `<span>${file.name}</span><span class="upload-item__status">Uploading…</span>`;
      progressBox.prepend(row);

      const fd = new FormData();
      fd.append('file', file);
      fd.append('folder', folderSel.value);
      fd.append('_token', csrfToken);

      try {
        const resp = await fetch('{{ route('admin.media.store') }}', { method:'POST', body:fd });
        const json = await resp.json();

        if (json.success) {
          row.querySelector('.upload-item__status').className = 'upload-item__status upload-item__status--ok';
          row.querySelector('.upload-item__status').textContent = '✓ Uploaded';
          addCard(json);
        } else {
          throw new Error(JSON.stringify(json.errors ?? json.message ?? 'Upload failed'));
        }
      } catch (err) {
        row.querySelector('.upload-item__status').className = 'upload-item__status upload-item__status--err';
        row.querySelector('.upload-item__status').textContent = '✗ Failed';
        console.error(err);
      }
    }
    fileInput.value = '';
  }

  function addCard(f) {
    const thumbHtml = f.is_image
      ? `<img src="${f.url}" alt="${f.name}" loading="lazy" />`
      : `<div class="media-card__icon${f.extension==='pdf'?' media-card__icon--pdf':''}">${f.extension.toUpperCase()}</div>`;

    const card = document.createElement('div');
    card.className = 'media-card';
    card.id = `media-card-${f.id}`;
    card.innerHTML = `
      <div class="media-card__thumb">${thumbHtml}</div>
      <div class="media-card__body">
        <p class="media-card__name" title="${f.name}">${f.name.length>22?f.name.slice(0,22)+'…':f.name}</p>
        <p class="media-card__meta">${f.extension.toUpperCase()} · ${f.size_formatted}</p>
      </div>
      <div class="media-card__actions">
        <button type="button" class="media-btn media-btn--copy" data-url="${f.url}" title="Copy URL">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><rect x="4" y="4" width="10" height="10" rx="1"/><path d="M2 12V2h10"/></svg>
        </button>
        <form method="POST" action="/admin/media/${f.id}" onsubmit="return confirm('Delete ${f.name}?')">
          <input type="hidden" name="_token" value="${csrfToken}">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="media-btn media-btn--del" title="Delete">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path d="M2 4h12M6 4V2h4v2M5 4l1 10h4l1-10"/></svg>
          </button>
        </form>
      </div>
      <span class="media-card__copied" id="copied-${f.id}" aria-live="polite">Copied!</span>`;

    // Remove "empty" placeholder if present
    const empty = document.querySelector('.media-empty');
    if (empty) empty.remove();

    newlyUpd.prepend(card);
    bindCopyBtn(card.querySelector('.media-btn--copy'));
  }

  // Copy URL buttons (existing + newly added)
  function bindCopyBtn(btn) {
    btn.addEventListener('click', () => {
      navigator.clipboard.writeText(btn.dataset.url).then(() => {
        const card   = btn.closest('.media-card');
        const tip    = card.querySelector('.media-card__copied');
        tip.classList.add('show');
        setTimeout(() => tip.classList.remove('show'), 1800);
      });
    });
  }

  document.querySelectorAll('.media-btn--copy').forEach(bindCopyBtn);
}());
</script>
@endpush
