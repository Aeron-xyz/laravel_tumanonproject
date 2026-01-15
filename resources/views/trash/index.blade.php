<x-layouts.app :title="__('Trash')">
    <style>[x-cloak]{display:none!important;}</style>

    <div class="space-y-6 text-white">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-3xl border border-white/10 bg-gradient-to-r from-[#22103e] via-[#2f1b5f] to-[#3c0d67] p-6 shadow-[0_35px_120px_rgba(15,0,30,0.6)] lg:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold sm:text-4xl">Trash</h1>
                    <p class="mt-2 text-white/60">Manage deleted crochet works</p>
                </div>
            </div>
        </section>

        <!-- Crochet Works Section -->
        <section class="rounded-3xl border border-white/10 bg-[#0c031b]/80 p-4 shadow-[0_35px_120px_rgba(5,0,10,0.9)] sm:p-6">
            <div class="flex flex-col gap-2 border-b border-white/10 pb-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-white/50">Deleted Items</p>
                    <h2 class="text-2xl font-semibold">Crochet Works</h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="mt-4 min-w-full text-left text-sm">
                    <thead class="text-xs uppercase tracking-[0.3em] text-white/40">
                        <tr class="border-b border-white/10">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Photo</th>
                            <th class="px-4 py-2">Work</th>
                            <th class="px-4 py-2">Collection</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Deleted At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($products as $product)
                            <tr class="transition hover:bg-white/5">
                                <td class="px-4 py-3 text-white/50">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    @if($product->photo)
                                        <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" style="width: 60.44px; height: 60.44px;" class="rounded-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-sm font-semibold text-white" style="width: 60.44px; height: 60.44px;">
                                            {{ $product->initials }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold">{{ $product->name }}</p>
                                    <p class="text-xs text-white/50">
                                        {{ $product->material ?? 'Crafted piece' }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs text-white/80">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-white/80">₱ {{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-3 text-white/60 text-xs">
                                    {{ $product->deleted_at->format('M j, Y g:i A') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div x-data="{ openRestore: false, openDelete: false }" class="flex items-center gap-3">
                                        <button type="button" @click="openRestore = true" class="text-emerald-300 hover:text-white">Restore</button>
                                        <button type="button" @click="openDelete = true" class="text-rose-300 hover:text-white">Delete</button>

                                        <div x-cloak x-show="openRestore" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                            <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0b001a] p-6 text-center shadow-2xl">
                                                <h3 class="text-xl font-semibold text-white">Restore crochet work?</h3>
                                                <p class="mt-2 text-sm text-white/70">
                                                    {{ $product->name }} will be restored to the dashboard.
                                                </p>
                                                <div class="mt-6 flex items-center justify-center gap-3">
                                                    <button type="button" @click="openRestore = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('trash.restore-product', $product->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-5 py-2 text-sm font-semibold text-white">
                                                            Restore
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-cloak x-show="openDelete" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                            <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0b001a] p-6 text-center shadow-2xl">
                                                <h3 class="text-xl font-semibold text-white">Permanently delete?</h3>
                                                <p class="mt-2 text-sm text-white/70">
                                                    {{ $product->name }} will be permanently deleted and cannot be recovered.
                                                </p>
                                                <div class="mt-6 flex items-center justify-center gap-3">
                                                    <button type="button" @click="openDelete = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('trash.force-delete-product', $product->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-2xl bg-gradient-to-r from-rose-500 to-orange-500 px-5 py-2 text-sm font-semibold text-white">
                                                            Delete Permanently
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-white/60">
                                    Trash is empty. No deleted crochet works.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Collections Section -->
        <section class="rounded-3xl border border-white/10 bg-[#0c031b]/80 p-4 shadow-[0_35px_120px_rgba(5,0,10,0.9)] sm:p-6">
            <div class="flex flex-col gap-2 border-b border-white/10 pb-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-white/50">Deleted Items</p>
                    <h2 class="text-2xl font-semibold">Collections</h2>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="mt-4 min-w-full text-left text-sm">
                    <thead class="text-xs uppercase tracking-[0.3em] text-white/40">
                        <tr class="border-b border-white/10">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Color</th>
                            <th class="px-4 py-2">Products</th>
                            <th class="px-4 py-2">Deleted At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($categories as $category)
                            <tr class="transition hover:bg-white/5">
                                <td class="px-4 py-3 text-white/50">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold">{{ $category->name }}</p>
                                    @if($category->description)
                                        <p class="text-xs text-white/50">{{ $category->description }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($category->color)
                                        <div class="h-6 w-6 rounded-full" style="background-color: {{ $category->color }};"></div>
                                    @else
                                        <span class="text-white/50 text-xs">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-white/80">{{ $category->products_count }} items</td>
                                <td class="px-4 py-3 text-white/60 text-xs">
                                    {{ $category->deleted_at->format('M j, Y g:i A') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div x-data="{ openRestore: false, openDelete: false }" class="flex items-center gap-3">
                                        <button type="button" @click="openRestore = true" class="text-emerald-300 hover:text-white">Restore</button>
                                        <button type="button" @click="openDelete = true" class="text-rose-300 hover:text-white">Delete</button>

                                        <div x-cloak x-show="openRestore" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                            <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0b001a] p-6 text-center shadow-2xl">
                                                <h3 class="text-xl font-semibold text-white">Restore collection?</h3>
                                                <p class="mt-2 text-sm text-white/70">
                                                    {{ $category->name }} will be restored to the collections page.
                                                </p>
                                                <div class="mt-6 flex items-center justify-center gap-3">
                                                    <button type="button" @click="openRestore = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('trash.restore-category', $category->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-5 py-2 text-sm font-semibold text-white">
                                                            Restore
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-cloak x-show="openDelete" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                            <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0b001a] p-6 text-center shadow-2xl">
                                                <h3 class="text-xl font-semibold text-white">Permanently delete?</h3>
                                                <p class="mt-2 text-sm text-white/70">
                                                    {{ $category->name }} will be permanently deleted and cannot be recovered.
                                                </p>
                                                <div class="mt-6 flex items-center justify-center gap-3">
                                                    <button type="button" @click="openDelete = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('trash.force-delete-category', $category->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-2xl bg-gradient-to-r from-rose-500 to-orange-500 px-5 py-2 text-sm font-semibold text-white">
                                                            Delete Permanently
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-white/60">
                                    No deleted collections.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layouts.app>
