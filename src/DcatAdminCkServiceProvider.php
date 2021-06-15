<?php

namespace Liyuu\DcatAdminCk;

use CKSource\CKFinder\CKFinder;
use Dcat\Admin\Admin;
use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Form;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\HttpKernel;
use Liyuu\DcatAdminCk\Http\Middleware\CKFinderMiddleware;

class DcatAdminCkServiceProvider extends ServiceProvider
{

    protected $middleware = [
        'middle' => [
            CKFinderMiddleware::class
        ],
    ];

    // 擴展管理發布資源
    public function publishable()
    {
        if ($assets = $this->getAssetPath()) {
            $this->publishes([
                $assets => public_path('vendor/dcat-ck'),
                __DIR__ . '/config.php' => config_path('ckfinder.php')
            ], $this->getName());
        }
    }

	public function init()
	{

        //if ($this->app->runningInConsole()) {
        //    $this->publishes([
        //        __DIR__.'/../resources/assets' => public_path('vendor/dcat-ck'),
        //        __DIR__ . '/config.php' => config_path('ckfinder.php')
        //    ], 'ckfinder');
        //}

        Admin::asset()->alias('@ckeditor', [
            'js' => [
                '/vendor/dcat-ck/ckeditor/ckeditor.js',
                '/vendor/dcat-ck/ckeditor/adapters/jquery.js',
                '/vendor/dcat-ck/ckfinder/ckfinder.js',
            ],
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dcat-ck');
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');

        Form::extend('ckeditor', CKEditor::class);
        Form::extend('ckuploader', CKUploader::class);

        parent::init();

	}

    public function register()
    {

        $this->app->bind('CKConnector', function () {

            $ckfinder = new CKFinder(config('ckfinder', []));

            if (Kernel::MAJOR_VERSION === 4) {
                $this->setupForV4Kernel($ckfinder);
            }

            return $ckfinder;
        });
    }

    protected function setupForV4Kernel($ckfinder)
    {
        $ckfinder['resolver'] = function () use ($ckfinder) {
            $commandResolver = new \Liyuu\DcatAdminCk\Polyfill\CommandResolver($ckfinder);
            $commandResolver->setCommandsNamespace(CKFinder::COMMANDS_NAMESPACE);
            $commandResolver->setPluginsNamespace(CKFinder::PLUGINS_NAMESPACE);

            return $commandResolver;
        };

        $ckfinder['kernel'] = function () use ($ckfinder) {
            return new HttpKernel(
                $ckfinder['dispatcher'],
                $ckfinder['resolver'],
                $ckfinder['request_stack'],
                $ckfinder['resolver']
            );
        };
    }
}
