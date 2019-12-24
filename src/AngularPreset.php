<?php

namespace Resonantic\AngularPreset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;
use Illuminate\Support\Arr;

class AngularPreset extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
        static::updateWebpackConfiguration();

        tap(new Filesystem, function (Filesystem $filesystem) {
            $filesystem->deleteDirectory(resource_path('js'));
            $filesystem->makeDirectory(resource_path('ts'));
            $filesystem->makeDirectory(resource_path('ts/app'));
            $filesystem->makeDirectory(resource_path('ts/environments'));
        });

        static::removeNodeModules();
        static::updateAngular();
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
                '@angular/animations' => '^8.2.0',
                '@angular/common' => '^8.2.0',
                '@angular/compiler' => '^8.2.0',
                '@angular/core' => '^8.2.0',
                '@angular/forms' => '^8.2.0',
                '@angular/http' => '^8.2.0',
                '@angular/platform-browser' => '^8.2.0',
                '@angular/platform-browser-dynamic' => '^8.2.0',
                '@angular/router' => '^8.2.0',
                '@types/node' => '^13.1.0',
                'core-js' => '^2.6.11',
                'rxjs' => '^6.5.3',
                'ts-loader' => '^6.2.1',
                'typescript' => '^3.7.4',
                'zone.js' => '^0.10.2',
            ] + Arr::except($packages, [
                'axios',
                'jquery',
                'vue-template-compiler',
                'vue',
            ]);
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__ . '/angular-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Angular files.
     *
     * @return void
     */
    protected static function updateAngular()
    {
        copy(__DIR__ . '/angular-stubs/app/main.ts', resource_path('ts/main.ts'));
        copy(__DIR__ . '/angular-stubs/app/app.module.ts', resource_path('ts/app/app.module.ts'));
        copy(__DIR__ . '/angular-stubs/app/app.component.ts', resource_path('ts/app/app.component.ts'));
        copy(__DIR__ . '/angular-stubs/app/environment.ts', resource_path('ts/environments/environment.ts'));
        copy(__DIR__ . '/angular-stubs/app/tsconfig.json', resource_path('ts/tsconfig.json'));
        copy(__DIR__ . '/angular-stubs/app/tslint.json', resource_path('ts/tslint.json'));
        copy(__DIR__ . '/angular-stubs/app/welcome.blade.php', resource_path('views/welcome.blade.php'));
        copy(__DIR__ . '/angular-stubs/polyfills.ts', resource_path('ts/polyfills.ts'));
        copy(__DIR__ . '/angular-stubs/vendor.ts', resource_path('ts/vendor.ts'));
        copy(__DIR__ . '/angular-stubs/tsconfig.json', base_path('tsconfig.json'));
    }
}
