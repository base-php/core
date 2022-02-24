<?php

use Aws\S3\S3MultiRegionClient;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use League\Flysystem\Ftp\FtpConnectionProvider;
use League\Flysystem\Ftp\NoopCommandConnectivityChecker;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\PhpseclibV2\SftpAdapter;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class Storage
{
    public $instance;

    public $filename;
    
    public $content;
    
    public $success;

    public $adapter;
    
    public function __construct($adapter = 'local')
    {
        if ($adapter == 'local') {
            $adapter        = new LocalFilesystemAdapter('/');
            $this->instance = new Filesystem($adapter);
            $this->adapter  = 'local';
        }

        // spatie/flysystem-dropbox
        if ($adapter == 'dropbox') {
            $client                 = new Client(config('dropbox'));
            $this->adapterInstance  = new DropboxAdapter($client);
            $this->instance         = new Filesystem($this->adapterInstance, ['case_sensitive' => false]);
            $this->adapter          = 'dropbox';
        }

        // league/flysystem-aws-s3-v3
        if ($adapter == 's3') {
            $client = new S3MultiRegionClient([
                'credentials' => [
                    'key'    => config('s3')->key,
                    'secret' => config('s3')->secret,
                ],
                'version'     => 'latest|version',
            ]);

            $this->adapterInstance  = new AwsS3Adapter($client, config('s3')->bucket);
            $this->instance         = new Filesystem($this->adapterInstance);
            $this->adapter          = 's3';
        }

        // league/flysystem-ftp
        if ($adapter == 'ftp') {
            $adapter = new FtpAdapter(
                FtpConnectionOptions::fromArray([
                    'host'     => config('ftp')->host,
                    'root'     => config('ftp')->root,
                    'username' => config('ftp')->username,
                    'password' => config('ftp')->password,
                ]),
                new FtpConnectionProvider(),
                new NoopCommandConnectivityChecker(),
                new PortableVisibilityConverter()
            );

            $this->instance = new Filesystem($adapter);
            $this->adapter  = 'ftp';
        }

        // league/flysystem-sftp
        if ($adapter == 'sftp') {
            $this->instance = new Filesystem(new SftpAdapter(
                new SftpConnectionProvider(
                    config('sftp')->localhost,
                    config('sftp')->username,
                    config('sftp')->password,
                    config('sftp')->private_key,
                    config('sftp')->passphrase,
                    config('sftp')->port,
                    true,
                    30,
                    10,
                    'fingerprint-string',
                    null
                ),
                config('sftp')->root,
                PortableVisibilityConverter::fromArray([
                    'file' => [
                        'public'  => 0640,
                        'private' => 0604,
                    ],
                    'dir'  => [
                        'public'  => 0740,
                        'private' => 7604,
                    ],
                ])
            ));

            $this->adapter = 'sftp';
        }
    }

    public function basename($file)
    {
        $pathinfo = pathinfo($file);
        return $pathinfo['filename'];
    }

    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    public function delete($path)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        $this->instance->delete($root . '/' . $path);
    }

    public function dir($path)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        return $this->instance->listContents($root . '/' . $path)->toArray();
    }
    
    public function disk($adapter)
    {
        $this->__construct($adapter);
        return $this;
    }

    public function download($file, $name = '')
    {
        $filename = ($name != '') ? $name : $file;
        $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $file;

        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="' . $filename . '"');
        readfile($file);
    }

    public function exists($file)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        return $this->instance->fileExists($root . '/' . $file);
    }

    public function extension($file)
    {
        $pathinfo = pathinfo($file);
        return $pathinfo['extension'];
    }

    public function file($file)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        $this->instance->write($root . '/' . $file, '');
    }

    public function get($get)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        return $this->instance->readStream($root . '/' . $get);
    }

    public function mime($path)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        return $this->instance->mimeType($root . '/' . $path);
    }

    public function mkdir($dir)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        $this->instance->createDirectory($dir);
    }

    public function modified($path)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        return date('Y-m-d h:i:s', $this->instance->lastModified($root . '/' . $path));
    }

    public function rename($old, $new)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        $this->instance->move($root . '/' . $old, $root . '/' . $new);
    }
    
    public function save($path, $filename = '')
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        $path = $root . '/' . $path;
        
        if (is_string($this->content)) {
            if (isset($_FILES[$this->content])) {
                if (is_array($_FILES[$this->content]['name'])) {
                    $i = 0;

                    foreach ($_FILES[$this->content]['name'] as $item) {
                        if ($_FILES[$this->content]['tmp_name'][$i] != '') {
                            $stream = fopen($_FILES[$this->content]['tmp_name'][$i], 'r');

                            $this->instance->writeStream($path . '/' . $_FILES[$this->content]['name'][$i], $stream);

                            $this->filename[] = $_FILES[$this->content]['name'][$i];
                            $this->success = true;

                            $i = $i + 1;
                        }
                    }

                } else {
                    if ($_FILES[$this->content]['name']) {
                        $filename = ($filename != '') ? $filename : $_FILES[$this->content]['name'];
                        $stream   = fopen($_FILES[$this->content]['tmp_name'], 'r');

                        $this->instance->writeStream($path . '/' . $filename, $stream);

                        $this->filename = $filename;
                        $this->success = true;                        
                    }
                }
            }
        }

        if (is_resource($this->content)) {
            $stream = $this->content;
            $this->instance->writeStream($path . '/' . $filename, $stream);

            $this->filename = $filename;
            $this->success = true;
        }

        return $this;
    }

    public function size($file)
    {
        $root = ($this->adapter == 'local') ? $_SERVER['DOCUMENT_ROOT'] : '';
        return $this->instance->fileSize($root . '/' . $file);
    }

    public function url($file)
    {
        if ($this->adapter == 'dropbox') {
            return $this->adapterInstance->getUrl($file);
        }

        if ($this->adapter == 's3') {
            return $this->adapterInstance->url($file);
        }

        return $file;
    }
}
