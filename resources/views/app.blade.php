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
        @vite('resources/js/app.ts')
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- Debug info - will be removed by JS if loading -->
        <div id="debug-info" style="position: fixed; top: 0; left: 0; background: #000; color: #fff; padding: 10px; z-index: 9999; font-size: 12px;">
            Loading Vite assets... If this persists, check console.
        </div>
        
        @inertia
        
        <script>
            // Remove debug info when Vue app loads
            setTimeout(function() {
                const debug = document.getElementById('debug-info');
                if (debug) debug.remove();
            }, 3000);
        </script>
        
        <script>
            // Remove debug info when app loads
            setTimeout(function() {
                const debug = document.getElementById('debug-info');
                if (debug) debug.remove();
            }, 3000);
        </script>
    </body>
</html>
