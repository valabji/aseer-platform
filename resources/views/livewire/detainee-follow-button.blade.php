<div>
    {{-- زر المتابعة وعدد المتابعين --}}
    <div class="d-flex align-items-center gap-2">
        <button wire:click="toggleFollow" wire:loading.attr="disabled"
                class="btn btn-sm rounded-pill {{ $isFollowing ? 'btn-outline-secondary' : 'btn-outline-success' }}">
            <i class="fas {{ $isFollowing ? 'fa-bell-slash' : 'fa-bell' }} me-1"></i>
            {{ $isFollowing ? 'إلغاء المتابعة' : 'متابعة' }}
        </button>

        <div class="d-flex align-items-center" style="gap: 10px;">
            <div style="width: 30px; height: 30px;"
                 class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm">
                <i class="fas fa-users fa-sm"></i>
            </div>
            <small class="text-muted">{{ $followersCount }} متابع</small>
        </div>
    </div>
</div>
