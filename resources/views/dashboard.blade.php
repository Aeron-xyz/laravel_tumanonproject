<x-layouts.app :title="__('Crochetel Studio')">
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
                    <h1 class="text-3xl font-semibold sm:text-4xl">Dashboard</h1>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 px-6 py-4 text-sm text-white/80">
                    <p class="uppercase tracking-[0.35em] text-white/50">Today</p>
                    <p class="text-lg font-semibold">{{ now()->format('l, F j') }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-white/5 bg-white/5 p-5 shadow-inner shadow-purple-900/30">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Crochet Works</p>
                    <div class="mt-4 flex items-end justify-between">
                        <span class="text-4xl font-semibold">{{ $stats['works'] }}</span>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/5 bg-white/5 p-5 shadow-inner shadow-pink-900/30">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Collections</p>
                    <div class="mt-4 flex items-end justify-between">
                        <span class="text-4xl font-semibold">{{ $stats['collections'] }}</span>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/5 bg-white/5 p-5 shadow-inner shadow-indigo-900/30">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Stocks</p>
                    <div class="mt-4 flex items-end justify-between">
                        <span class="text-4xl font-semibold">{{ $stats['stockTotal'] }}</span>
                        <span class="text-sm text-white/60">{{ $stats['lowStock'] }} low</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[minmax(0,420px)_minmax(0,1fr)]">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-[0_25px_60px_rgba(5,0,15,0.8)]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-white/50">New Crochet Work</p>
                        <h2 class="mt-2 text-xl font-semibold">Add Inventory</h2>
                    </div>
                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs text-white/70">Real-time</span>
                </div>

                <form action="{{ route('products.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Luna Shell Blanket" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40">
                        @error('name','createProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm text-white/70">Price</label>
                            <input type="number" min="0" step="0.01" name="price" value="{{ old('price') }}" placeholder="0.00" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40">
                            @error('price','createProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm text-white/70">Stock</label>
                            <input type="number" min="0" name="stock" value="{{ old('stock') }}" placeholder="0" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40">
                            @error('stock','createProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Material</label>
                        <input type="text" name="material" value="{{ old('material') }}" placeholder="Merino blend" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40">
                        @error('material','createProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Collection</label>
                        <select name="category_id" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40">
                            <option value="">Unassigned</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id','createProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Description</label>
                        <textarea name="description" rows="3" placeholder="Stitch story, palette, or packaging notes" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40">{{ old('description') }}</textarea>
                        @error('description','createProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-[#c084fc] to-[#7c3aed] px-4 py-3 text-center text-sm font-semibold uppercase tracking-[0.35em] text-white shadow-lg shadow-purple-900/50 transition hover:opacity-90">
                        Save Work
                    </button>
                </form>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[#0c031b]/80 p-4 shadow-[0_35px_120px_rgba(5,0,10,0.9)] sm:p-6">
                <div class="flex flex-col gap-2 border-b border-white/10 pb-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-white/50">Live Inventory</p>
                        <h2 class="text-2xl font-semibold">Crochet Works</h2>
                    </div>
                    <span class="text-sm text-white/60">Last sync {{ now()->format('g:i A') }}</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="mt-4 min-w-full text-left text-sm">
                        <thead class="text-xs uppercase tracking-[0.3em] text-white/40">
                            <tr class="border-b border-white/10">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Work</th>
                                <th class="px-4 py-2">Collection</th>
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2">Stock</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($products as $product)
                                <tr class="transition hover:bg-white/5">
                                    <td class="px-4 py-3 text-white/50">{{ $loop->iteration }}</td>
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
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-3 py-1 text-xs {{ $product->stock < 5 ? 'bg-orange-500/20 text-orange-200' : 'bg-emerald-500/20 text-emerald-100' }}">
                                            {{ $product->stock }} pcs
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div x-data="{ openEdit: false, openDelete: false }" class="flex items-center gap-3">
                                            <button type="button" @click="openEdit = true" class="text-purple-300 hover:text-white">Edit</button>
                                            <button type="button" @click="openDelete = true" class="text-rose-300 hover:text-white">Delete</button>

                                            <div x-cloak x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                                <div class="w-full max-w-2xl rounded-3xl border border-white/10 bg-[#0b001a] p-6 shadow-2xl">
                                                    <div class="mb-4 flex items-center justify-between">
                                                        <h3 class="text-xl font-semibold">Edit Crochet Work</h3>
                                                        <button type="button" class="text-white/50 hover:text-white" @click="openEdit = false">✕</button>
                                                    </div>
                                                    <form action="{{ route('products.update', $product) }}" method="POST" class="grid gap-4 md:grid-cols-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Name</label>
                                                            <input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                            @error('name','updateProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Price</label>
                                                            <input type="number" name="price" min="0" step="0.01" value="{{ $product->price }}" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                            @error('price','updateProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Stock</label>
                                                            <input type="number" name="stock" min="0" value="{{ $product->stock }}" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                            @error('stock','updateProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Material</label>
                                                            <input type="text" name="material" value="{{ $product->material }}" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                            @error('material','updateProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Collection</label>
                                                            <select name="category_id" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                                <option value="">Unassigned</option>
                                                                @foreach($categories as $categoryOption)
                                                                    <option value="{{ $categoryOption->id }}" @selected($product->category_id === $categoryOption->id)>{{ $categoryOption->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id','updateProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="md:col-span-2 space-y-2">
                                                            <label class="text-sm text-white/70">Description</label>
                                                            <textarea name="description" rows="3" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">{{ $product->description }}</textarea>
                                                            @error('description','updateProduct')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="md:col-span-2 flex items-center justify-end gap-3 pt-2">
                                                            <button type="button" @click="openEdit = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">Cancel</button>
                                                            <button type="submit" class="rounded-2xl bg-gradient-to-r from-[#c084fc] to-[#7c3aed] px-6 py-2 text-sm font-semibold uppercase tracking-[0.35em]">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div x-cloak x-show="openDelete" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                                <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0b001a] p-6 text-center shadow-2xl">
                                                    <h3 class="text-xl font-semibold text-white">Remove crochet work?</h3>
                                                    <p class="mt-2 text-sm text-white/70">
                                                        {{ $product->name }} will disappear from the studio but any linked orders remain untouched.
                                                    </p>
                                                    <div class="mt-6 flex items-center justify-center gap-3">
                                                        <button type="button" @click="openDelete = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this crochet work?')" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="rounded-2xl bg-gradient-to-r from-rose-500 to-orange-500 px-5 py-2 text-sm font-semibold text-white">
                                                                Delete
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
                                        No crochet works yet. Use the form on the left to craft your first piece.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
