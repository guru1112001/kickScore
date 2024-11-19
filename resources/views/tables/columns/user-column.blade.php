<div style="display: flex; align-items: center;">
    <img src="{{ $getRecord()?->user?->avatar_url ? asset('storage/' . $getRecord()->user->avatar_url) : '/path/to/default-avatar.png' }}" 
         alt="{{ $getRecord()?->user?->name ?? 'No Name' }}" 
         style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
    <span>{{ $getRecord()?->user?->name ?? 'No Name Available' }}</span>
</div>
