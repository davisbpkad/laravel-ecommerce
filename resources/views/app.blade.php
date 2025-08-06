<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }

            /* Debug style - remove after fixing */
            body {
                min-height: 100vh;
                background-color: #f3f4f6; /* Light gray background for debugging */
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        {{-- Temporarily disable Vite to test if backend works --}}
        {{-- @vite('resources/js/app.ts') --}}
        
        <!-- Inline basic styles for testing -->
        <style>
            body { font-family: sans-serif; padding: 20px; background: #f5f5f5; }
            .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
            .error { color: red; padding: 10px; background: #fee; border: 1px solid #fcc; border-radius: 4px; }
            .success { color: green; padding: 10px; background: #efe; border: 1px solid #cfc; border-radius: 4px; }
        </style>
        
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <div class="container">
            <h1>Laravel E-commerce - Debug Mode</h1>
            <div class="success">✅ Laravel is working! Backend connected successfully.</div>
            <div class="error">❌ Vite assets disabled for debugging. Check Railway build logs.</div>
            <p>If you see this page, the Laravel backend is working correctly. The issue is with Vite asset compilation.</p>
        </div>
        
        {{-- Temporarily disable @inertia while testing --}}
        {{-- @inertia --}}
        
        <script>
            // Remove debug info when app loads
            setTimeout(function() {
                const debug = document.getElementById('debug-info');
                if (debug) debug.remove();
            }, 3000);
        </script>
    </body>
</html>
