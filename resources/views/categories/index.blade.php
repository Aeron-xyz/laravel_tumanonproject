<x-layouts.app :title="__('Crochetel Collections')">
    <style>[x-cloak]{display:none!important;}</style>

    <div class="space-y-6 text-white">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-3xl border border-white/10 bg-gradient-to-r from-[#2e014c] via-[#3b0c61] to-[#4c0f73] p-6 shadow-[0_35px_120px_rgba(12,0,25,0.8)] lg:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold sm:text-4xl">Collections</h1>
                </div>
                <div class="grid gap-2 rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-sm">
                    <p class="text-white/60">Busiest set</p>
                    <p class="text-xl font-semibold">{{ $stats['richest'] }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <article class="rounded-2xl border border-white/5 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Collections</p>
                    <p class="mt-3 text-4xl font-semibold">{{ $stats['collections'] }}</p>
                </article>
                <article class="rounded-2xl border border-white/5 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Crochet Works</p>
                    <p class="mt-3 text-4xl font-semibold">{{ $stats['works'] }}</p>
                </article>
                <article class="rounded-2xl border border-white/5 bg-white/5 p-5">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Highlight</p>
                    <p class="mt-3 text-lg font-semibold">{{ $stats['richest'] }}</p>
                </article>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[minmax(0,420px)_minmax(0,1fr)]">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-[0_25px_60px_rgba(8,0,20,0.8)]">
                <p class="text-xs uppercase tracking-[0.35em] text-white/60">New collection</p>
                <h2 class="mt-2 text-2xl font-semibold">Add a set</h2>
                <p class="mt-2 text-sm text-white/70">Think hues, vibe, or launch series.</p>

                <form action="{{ route('categories.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-fuchsia-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-400/40">
                        @error('name','createCategory')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Accent color (hex)</label>
                        <input type="text" name="color" value="{{ old('color') }}" placeholder="#a855f7" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-fuchsia-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-400/40">
                        @error('color','createCategory')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm text-white/70">Description</label>
                        <textarea name="description" rows="3" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-fuchsia-300 focus:outline-none focus:ring-2 focus:ring-fuchsia-400/40">{{ old('description') }}</textarea>
                        @error('description','createCategory')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-[#c084fc] to-[#7c3aed] px-4 py-3 text-center text-sm font-semibold uppercase tracking-[0.35em] text-white shadow-lg shadow-purple-900/50 transition hover:opacity-90">
                        Save Collection
                    </button>
                </form>
            </div>

            <div class="rounded-3xl border border-white/10 bg-[#0c031b]/80 p-4 shadow-[0_35px_120px_rgba(5,0,10,0.9)] sm:p-6">
                <div class="flex flex-col gap-2 border-b border-white/10 pb-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-white/50">Directory</p>
                        <h2 class="text-2xl font-semibold">Collections</h2>
                    </div>
                    <span class="text-sm text-white/60">{{ $categories->count() }} total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="mt-4 min-w-full text-left text-sm">
                        <thead class="text-xs uppercase tracking-[0.3em] text-white/40">
                            <tr class="border-b border-white/10">
                                <th class="px-4 py-2">Collection</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Works</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($categories as $category)
                                <tr class="transition hover:bg-white/5">
                                    <td class="px-4 py-4 font-semibold">
                                        <div class="flex items-center gap-3">
                                            <span class="h-3 w-3 rounded-full" style="background: {{ $category->color ?? '#c084fc' }}"></span>
                                            <span>{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-white/70">{{ $category->description ?? '—' }}</td>
                                    <td class="px-4 py-4">
                                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs text-white/80">
                                            {{ $category->products_count }} {{ \Illuminate\Support\Str::plural('work', $category->products_count) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <div x-data="{ openEdit: false, openDelete: false }" class="flex items-center gap-3">
                                            <button type="button" @click="openEdit = true" class="text-purple-300 hover:text-white">Edit</button>
                                            <button type="button" @click="openDelete = true" class="text-rose-300 hover:text-white">Delete</button>

                                            <div x-cloak x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                                <div class="w-full max-w-lg rounded-3xl border border-white/10 bg-[#0b001a] p-6 shadow-2xl">
                                                    <div class="mb-4 flex items-center justify-between">
                                                        <h3 class="text-xl font-semibold">Edit Collection</h3>
                                                        <button type="button" class="text-white/50 hover:text-white" @click="openEdit = false">✕</button>
                                                    </div>
                                                    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Name</label>
                                                            <input type="text" name="name" value="{{ $category->name }}" required class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                            @error('name','updateCategory')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Accent color</label>
                                                            <input type="text" name="color" value="{{ $category->color }}" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">
                                                            @error('color','updateCategory')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="space-y-2">
                                                            <label class="text-sm text-white/70">Description</label>
                                                            <textarea name="description" rows="3" class="w-full rounded-2xl border border-white/10 bg-[#16022d]/70 px-4 py-3 text-sm text-white">{{ $category->description }}</textarea>
                                                            @error('description','updateCategory')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                                                        </div>
                                                        <div class="flex items-center justify-end gap-3 pt-2">
                                                            <button type="button" @click="openEdit = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">Cancel</button>
                                                            <button type="submit" class="rounded-2xl bg-gradient-to-r from-[#c084fc] to-[#7c3aed] px-6 py-2 text-sm font-semibold uppercase tracking-[0.35em]">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <div x-cloak x-show="openDelete" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
                                                <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#0b001a] p-6 text-center shadow-2xl">
                                                    <h3 class="text-xl font-semibold text-white">Delete collection?</h3>
                                                    <p class="mt-2 text-sm text-white/70">Works will stay available but their collection becomes N/A.</p>
                                                    <div class="mt-6 flex items-center justify-center gap-3">
                                                        <button type="button" @click="openDelete = false" class="rounded-2xl border border-white/10 px-4 py-2 text-sm text-white/70">Cancel</button>
                                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this collection?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="rounded-2xl bg-gradient-to-r from-rose-500 to-orange-500 px-6 py-2 text-sm font-semibold text-white">
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
                                    <td colspan="4" class="px-4 py-12 text-center text-sm text-white/60">
                                        Start your first palette above to see it appear here.
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
