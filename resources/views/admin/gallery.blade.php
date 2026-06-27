<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage gallery — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Mukta:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --maroon: #7A1230;
      --gold: #C9912E;
      --teal: #1B4D44;
      --ivory: #FFF6E9;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Mukta', sans-serif;
      background: var(--ivory);
      color: var(--maroon);
      padding: 30px 20px;
    }

    .wrap {
      max-width: 700px;
      margin: 0 auto;
    }

    h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 26px;
      margin-bottom: 4px;
    }

    .nav {
      margin-bottom: 24px;
      font-size: 13px;
    }

    .nav a {
      color: var(--teal);
      text-decoration: none;
      font-weight: 600;
      margin-right: 16px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #eee;
    }

    .upload-form {
      display: flex;
      gap: 10px;
      align-items: flex-end;
      flex-wrap: wrap;
    }

    .upload-form input[type="text"] {
      padding: 9px 10px;
      border: 1px solid var(--gold);
      border-radius: 6px;
      font-size: 14px;
      flex: 1;
      min-width: 160px;
    }

    .upload-form input[type="file"] {
      font-size: 13px;
    }

    .upload-form button {
      background: var(--maroon);
      color: var(--ivory);
      border: none;
      border-radius: 6px;
      padding: 9px 16px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
    }

    .banner {
      background: var(--teal);
      color: var(--ivory);
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 18px;
    }

    .error {
      color: #B3261E;
      font-size: 13px;
      margin-bottom: 14px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 14px;
    }

    .img-card {
      background: #fff;
      border: 1px solid #eee;
      border-radius: 8px;
      overflow: hidden;
    }

    .img-card img {
      width: 100%;
      height: 110px;
      object-fit: cover;
      display: block;
    }

    .img-card .meta {
      padding: 8px;
      font-size: 11px;
    }

    .del-btn {
      font-size: 11px;
      border: 1px solid #B3261E;
      color: #B3261E;
      background: #fff;
      border-radius: 12px;
      padding: 3px 9px;
      cursor: pointer;
      width: 100%;
      margin-top: 4px;
    }

    .empty {
      padding: 20px;
      text-align: center;
      color: var(--teal);
      font-size: 13px;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1>Manage gallery</h1>
    <div class="nav"><a href="{{ route('admin.dashboard', ['key' => $key]) }}">&larr; Back to dashboard</a></div>

    @if (session('image_uploaded'))
    <div class="banner">Photo uploaded.</div>
    @endif
    @error('image')
    <div class="error">{{ $message }}</div>
    @enderror

    <div class="card">
      <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 18px; margin-bottom: 14px;">Upload a photo</h2>
      <form class="upload-form" method="POST" action="{{ route('admin.gallery.upload', ['key' => $key]) }}" enctype="multipart/form-data">
        @csrf
        <input
          type="file"
          name="images[]"
          multiple
          accept="image/*">
        <input type="text" name="caption" placeholder="Caption (optional)" maxlength="255">
        <button type="submit">Upload</button>
      </form>
    </div>

    @if ($images->isEmpty())
    <div class="empty">No photos uploaded yet.</div>
    @else
    <div class="grid">
      @foreach ($images as $image)
      <div class="img-card">
        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? '' }}">
        <div class="meta">
          {{ $image->caption ?: 'No caption' }}
          <form method="POST" action="{{ route('admin.gallery.delete', ['image' => $image->id, 'key' => $key]) }}" onsubmit="return confirm('Remove this photo?');">
            @csrf @method('DELETE')
            <button class="del-btn" type="submit">Remove</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</body>

</html>