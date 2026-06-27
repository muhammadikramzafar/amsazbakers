@extends('frontend.layouts.app')

@section('title', $galleryAlbum->name.' — Gallery — Azmeer Bakery')
@section('meta_description', Str::limit($galleryAlbum->description ?: 'View '.$galleryAlbum->name.' gallery at Azmeer Bakery.', 155))

@push('styles')
<style>
.gallery-detail { max-width:var(--container-max); margin:0 auto; padding:60px var(--container-pad); }
.gallery-masonry { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:12px; }
.gallery-item { border-radius:8px; overflow:hidden; cursor:pointer; position:relative; aspect-ratio:1; background:#f3e2c7; }
.gallery-item img { width:100%; height:100%; object-fit:cover; transition:transform .3s; }
.gallery-item:hover img { transform:scale(1.06); }
.gallery-item__caption { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(0,0,0,.7)); color:#fff; padding:20px 12px 10px; font-size:13px; opacity:0; transition:opacity .2s; }
.gallery-item:hover .gallery-item__caption { opacity:1; }
.gallery-item__play { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:40px; color:#fff; text-shadow:0 2px 8px rgba(0,0,0,.5); }
.other-albums { margin-top:60px; padding-top:40px; border-top:1px solid var(--clr-border); }
.other-albums-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:16px; margin-top:20px; }
.other-album-card img { width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:8px; }
.other-album-card a { font-size:14px; font-weight:600; color:var(--clr-heading); text-decoration:none; display:block; margin-top:6px; }

/* Lightbox */
#lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.92); z-index:9999; align-items:center; justify-content:center; }
#lightbox.open { display:flex; }
#lightbox img { max-width:90vw; max-height:88vh; border-radius:8px; object-fit:contain; }
#lightbox-close { position:fixed; top:20px; right:24px; color:#fff; font-size:32px; cursor:pointer; z-index:10000; line-height:1; }
#lightbox-prev, #lightbox-next { position:fixed; top:50%; transform:translateY(-50%); color:#fff; font-size:40px; cursor:pointer; background:rgba(255,255,255,.1); padding:10px 14px; border-radius:8px; z-index:10000; user-select:none; }
#lightbox-prev { left:16px; }
#lightbox-next { right:16px; }
#lightbox-caption { position:fixed; bottom:20px; left:50%; transform:translateX(-50%); color:#fff; font-size:14px; text-align:center; max-width:80vw; }
</style>
@endpush

@section('content')
  <section class="page-banner">
    <nav class="breadcrumb"><a href="{{ route('home') }}" class="breadcrumb__link">Home</a><span class="breadcrumb__sep">/</span><a href="{{ route('gallery.index') }}" class="breadcrumb__link">Gallery</a><span class="breadcrumb__sep">/</span><span class="breadcrumb__current">{{ $galleryAlbum->name }}</span></nav>
    <h1 class="page-banner__title">{{ $galleryAlbum->name }}</h1>
    <span class="gold-rule gold-rule--center"></span>
    @if($galleryAlbum->description)<p style="margin-top:12px;color:#888;">{{ $galleryAlbum->description }}</p>@endif
  </section>

  <div class="gallery-detail">
    @if($items->isEmpty())
      <p style="text-align:center;padding:60px 0;color:#aaa;">No items in this album yet.</p>
    @else
      <div class="gallery-masonry">
        @foreach($items as $i => $item)
        @if($item->type === 'image')
          <div class="gallery-item" onclick="openLightbox({{ $i }})" data-url="{{ $item->file_url }}" data-caption="{{ $item->caption }}">
            <img src="{{ $item->thumb_url }}" alt="{{ $item->caption }}" loading="lazy" />
            @if($item->caption)<div class="gallery-item__caption">{{ $item->caption }}</div>@endif
          </div>
        @else
          <a href="{{ $item->video_url }}" target="_blank" class="gallery-item">
            <div style="width:100%;height:100%;background:#111;display:flex;align-items:center;justify-content:center;">
              <span class="gallery-item__play">▶</span>
            </div>
            @if($item->caption)<div class="gallery-item__caption">{{ $item->caption }}</div>@endif
          </a>
        @endif
        @endforeach
      </div>
      <div style="margin-top:32px;">{{ $items->links() }}</div>
    @endif

    @if($otherAlbums->isNotEmpty())
    <div class="other-albums">
      <div class="section-header section-header--left"><h2 class="section-heading">More Albums</h2><span class="gold-rule"></span></div>
      <div class="other-albums-grid">
        @foreach($otherAlbums as $oa)
        <div class="other-album-card">
          <a href="{{ route('gallery.show', $oa->slug) }}">
            <img src="{{ $oa->cover_image_url ?? 'https://placehold.co/400x300/f3e2c7/5a3e2b?text='.urlencode($oa->name) }}" alt="{{ $oa->name }}" loading="lazy" />
          </a>
          <a href="{{ route('gallery.show', $oa->slug) }}">{{ $oa->name }}</a>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  <!-- Lightbox -->
  <div id="lightbox" onclick="if(event.target===this)closeLightbox()">
    <span id="lightbox-close" onclick="closeLightbox()">×</span>
    <span id="lightbox-prev" onclick="changeImage(-1)">&#8249;</span>
    <img id="lightbox-img" src="" alt="" />
    <span id="lightbox-next" onclick="changeImage(1)">&#8250;</span>
    <div id="lightbox-caption"></div>
  </div>
@endsection

@push('scripts')
<script>
const galleryItems = Array.from(document.querySelectorAll('.gallery-item[data-url]'));
let currentIdx = 0;

function openLightbox(i) {
  currentIdx = i;
  showImage(i);
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow = '';
}

function showImage(i) {
  const el = galleryItems[i];
  document.getElementById('lightbox-img').src = el.dataset.url;
  document.getElementById('lightbox-caption').textContent = el.dataset.caption || '';
}

function changeImage(dir) {
  currentIdx = (currentIdx + dir + galleryItems.length) % galleryItems.length;
  showImage(currentIdx);
}

document.addEventListener('keydown', e => {
  if (!document.getElementById('lightbox').classList.contains('open')) return;
  if (e.key === 'Escape') closeLightbox();
  if (e.key === 'ArrowLeft')  changeImage(-1);
  if (e.key === 'ArrowRight') changeImage(1);
});
</script>
@endpush
