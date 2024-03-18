<?php

namespace Luscio\LaravelFilesystem\Oss;

use Iidestiny\Flysystem\Oss\OssAdapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class OssStorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Storage::extend('oss', function ($app, $config) {
            $adapter = new OssAdapter(
                $config['access_key'],
                $config['secret_key'],
                $config['endpoint'],
                $config['bucket'],
                $config['isCName'],
                $config['root'] ?? null,
                $config['buckets'] ?? [],
            );
            $adapter->setCdnUrl($config['url'] ?? null);
            return new FilesystemAdapter(new Filesystem($adapter), $adapter);
        });
    }

    /**
     * Register any application services.
     */
    public function register() {}
}
