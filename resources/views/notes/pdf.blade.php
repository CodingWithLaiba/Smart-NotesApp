<!doctype html>
<html><head><meta charset="utf-8"><title>{{ $note->title }}</title>
<style>
    body { font-family: sans-serif; color: #222; padding: 24px; }
    h1 { border-bottom: 2px solid #333; padding-bottom: 8px; }
    .meta { color: #666; font-size: 12px; margin-bottom: 16px; }
</style></head>
<body>
    <h1>{{ $note->title }}</h1>
    <div class="meta">Created: {{ $note->created_at->toDayDateTimeString() }}</div>
    <div>{!! $note->content !!}</div>
</body></html>
