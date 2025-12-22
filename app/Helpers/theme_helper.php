<?php

if (! function_exists('theme_view')) {
    /**
     * Render a view with theme override support.
     *
     * - If a themed view exists under app/Views/themes/<site.type>/..., render it first.
     * - Otherwise fall back to the app view path passed in.
     */
    function theme_view(string $view, array $data = []): string {
        $theme = env('site.type') ?: 'app';
        $themeView = $view;

        if (str_starts_with($themeView, 'frontend/')) {
            $themeView = substr($themeView, strlen('frontend/'));
        }

        $themeBase = APPPATH . 'Views/themes/' . $theme . '/';
        $themeFile = $themeBase . $themeView . '.php';

        if (is_file($themeFile)) {
            return view('themes/' . $theme . '/' . $themeView, $data);
        }

        return view($view, $data);
    }
}
