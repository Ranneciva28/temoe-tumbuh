@php
$brandAsset = function (?string $path): ?string {
    if (!$path) return null;
    return str_starts_with($path, 'http') ? $path : asset(ltrim($path, '/'));
};
$faviconUrl = $brandAsset($branding['favicon_url'] ?? null);
$appIconUrl = $brandAsset($branding['app_icon_url'] ?? null) ?: $faviconUrl;
@endphp
@if($faviconUrl)<link rel="icon" href="{{ $faviconUrl }}">@endif
@if($appIconUrl)<link rel="apple-touch-icon" href="{{ $appIconUrl }}">@endif
<meta name="theme-color" content="#173d31">
