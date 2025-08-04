<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-md border-2 border-[#44403c] px-6 py-2 text-base font-bold 
                    text-[#1b1b18]  shadow-[4px_4px_0_#44403c] transition hover:shadow-[6px_6px_0_#44403c]
                    hover:translate-x-[-2px] hover:shadow-none"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-md border-2 border-[#44403c] px-6 py-2 text-base font-bold 
                        text-[#1b1b18]  shadow-[4px_4px_0_#44403c] transition hover:shadow-[6px_6px_0_#44403c]
                        hover:translate-x-[-2px] hover:shadow-none"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-md border-2 border-[#44403c] px-6 py-2 text-base font-bold 
                        text-[#1b1b18]  shadow-[4px_4px_0_#44403c] transition hover:shadow-[6px_6px_0_#44403c]
                        hover:translate-x-[-2px]  hover:shadow-none"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                >
                    <h1 class="mb-4 text-2xl font-bold leading-tight lg:text-3xl">
                        Welcome to <span class="text-[#FFB800]">Inertia</span> + <span class="text-[#FFB800]">Vue 3</span> + <span class="text-[#FFB800]">Laravel</span>
                    </h1>
                    <p class="mb-6">
                        This is a simple starter template for building applications with Inertia.js, Vue 3, and Laravel. You can start building your application from here.
                    </p>
                    <p>
                        For more information, check out the documentation:
                        <a
                            href="https://inertiajs.com/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-[#FFB800] hover:underline"
                        >
                            Inertia.js Documentation
                        </a>
                    </p>
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
