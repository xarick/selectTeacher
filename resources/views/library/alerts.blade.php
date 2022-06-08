<div x-data="alertFunc">
    @if ($errors->any())
        <div class="px-4 py-2 mb-4 text-sm text-red-700 bg-red-100 rounded" role="alert" x-show="show"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <span class="font-medium">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="py-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </span>
        </div>
    @endif
    @if ($error = Session::get('error'))
        <div class="px-4 py-2 mb-4 text-sm text-red-700 bg-red-100 rounded" role="alert" x-show="show"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <span class="font-medium">{{ $error }}</span>
        </div>
    @endif
    @if ($success = Session::get('success'))
        <div class="px-4 py-2 mb-4 text-sm text-green-700 bg-green-100 rounded" role="alert" x-show="show"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <span class="font-medium">{{ $success }}</span>
        </div>
    @endif
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('alertFunc', () => ({
            show: true,
            init() {
                setTimeout(() => this.show = false, 5000);
            },
        }))
    })
</script>
