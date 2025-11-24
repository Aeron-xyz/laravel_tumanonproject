<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#050014] text-white">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-br from-[#050014] via-[#0f0227] to-[#1c0f33] text-white">
        <div class="flex min-h-screen">
            <flux:sidebar sticky stashable class="border-e border-white/5 bg-[#0a0117]/90 p-4 text-white backdrop-blur-2xl">
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

                <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rounded-2xl bg-gradient-to-r from-[#c084fc] to-[#a855f7] px-3 py-2 text-white shadow-2xl shadow-purple-900/40 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>

                <flux:navlist variant="outline" class="mt-6 space-y-2 border-0 bg-transparent">
                    <flux:navlist.group class="grid gap-2">
                        <flux:navlist.item class="rounded-2xl bg-white/10 text-white" icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item class="rounded-2xl bg-white/5 text-white" icon="layout-grid" :href="route('categories.index')" :current="request()->routeIs('categories.*')" wire:navigate>{{ __('Collections') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>

                <flux:spacer />

                <!-- Desktop User Menu -->
                <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                    <flux:profile
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                        icon:trailing="chevrons-up-down"
                        class="rounded-2xl bg-white/5 px-2"
                    />

                    <flux:menu class="w-[220px] rounded-2xl border-white/10 bg-[#05000f]/90 text-white backdrop-blur">
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg bg-white/10">
                                        <span class="flex h-full w-full items-center justify-center text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold text-white">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs text-white/60">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" class="text-white" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-200 hover:text-red-400">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:sidebar>

            <div class="flex-1">
                <!-- Mobile User Menu -->
                <flux:header class="lg:hidden border-b border-white/10 bg-[#0d0120]/80 text-white backdrop-blur">
                    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

                    <flux:spacer />

                    <flux:dropdown position="top" align="end">
                        <flux:profile
                            :initials="auth()->user()->initials()"
                            icon-trailing="chevron-down"
                        />

                        <flux:menu class="rounded-2xl border-white/10 bg-[#05000f]/90 text-white backdrop-blur">
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg bg-white/10">
                                            <span class="flex h-full w-full items-center justify-center text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold text-white">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs text-white/60">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('settings.profile')" icon="cog" class="text-white" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-200 hover:text-red-400">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </flux:header>

                <main class="px-4 py-6 sm:px-8 sm:py-10">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
        @fluxScripts
    </body>
</html>
