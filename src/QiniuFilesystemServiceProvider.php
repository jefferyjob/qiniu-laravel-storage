<?php namespace Jefferyjob\QiniuStorage;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Jefferyjob\QiniuStorage\Plugins\DownloadUrl;
use Jefferyjob\QiniuStorage\Plugins\Fetch;
use Jefferyjob\QiniuStorage\Plugins\ImageExif;
use Jefferyjob\QiniuStorage\Plugins\ImageInfo;
use Jefferyjob\QiniuStorage\Plugins\AvInfo;
use Jefferyjob\QiniuStorage\Plugins\ImagePreviewUrl;
use Jefferyjob\QiniuStorage\Plugins\LastReturn;
use Jefferyjob\QiniuStorage\Plugins\PersistentFop;
use Jefferyjob\QiniuStorage\Plugins\PersistentStatus;
use Jefferyjob\QiniuStorage\Plugins\PrivateDownloadUrl;
use Jefferyjob\QiniuStorage\Plugins\Qetag;
use Jefferyjob\QiniuStorage\Plugins\UploadToken;
use Jefferyjob\QiniuStorage\Plugins\PrivateImagePreviewUrl;
use Jefferyjob\QiniuStorage\Plugins\VerifyCallback;
use Jefferyjob\QiniuStorage\Plugins\WithUploadToken;

class QiniuFilesystemServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Storage::extend(
            'qiniu',
            function ($app, $config) {
                if (isset($config['domains'])) {
                    $domains = $config['domains'];
                } else {
                    $domains = [
                        'default' => $config['domain'],
                        'https'   => null,
                        'custom'  => null
                    ];
                }
                $qiniu_adapter = new QiniuAdapter(
                    $config['access_key'],
                    $config['secret_key'],
                    $config['bucket'],
                    $domains,
                    isset($config['notify_url']) ? $config['notify_url'] : null,
                    isset($config['access']) ? $config['access'] : 'public',
                    isset($config['hotlink_prevention_key']) ? $config['hotlink_prevention_key'] : null
                );
                $file_system = new Filesystem($qiniu_adapter);

                return new FilesystemAdapter($file_system, $qiniu_adapter, $config);
            }
        );
    }

    public function register()
    {
        //
    }
}
