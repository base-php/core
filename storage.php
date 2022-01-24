<?php

use Aws\S3\S3MultiRegionClient;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FTP\FtpAdapter;
use League\Flysystem\FTP\FtpConnectionOptions;
use League\Flysystem\FTP\FtpConnectionProvider;
use League\Flysystem\FTP\NoopCommandConnectivityChecker;
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
    
    public function __construct($adapter = 'local')
    {
        if ($adapter == 'local') {
            $adapter        = new LocalFilesystemAdapter('/');
            $this->instance = new Filesystem($adapter);
        }

        // spatie/flysystem-dropbox
        if ($adapter == 'dropbox') {
            $client         = new Client(config('dropbox')->access_token);
            $adapter        = new DropboxAdapter($client);
            $this->instance = new Filesystem($adapter, ['case_sensitive' => false]);
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

            $adapter        = new AwsS3Adapter($client, config('s3')->bucket);
            $this->instance = new Filesystem($adapter);
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
        }
    }
    
    public function adapter($adapter)
    {
        return $this->__construct($adapter);
    }
    
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }
    
    public function delete($path)
    {
        $this->instance->delete($path);
    }
    
    public function get($get)
    {
        return $this->instance->readStream($get);
    }
    
    public function save($path, $filename = '')
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        
        if (is_string($this->content)) {
            if (isset($_FILES[$this->content])) {
                if (is_array($_FILES[$this->content]['name'])) {
                    $i = 0;

                    foreach ($_FILES[$this->content]['name'] as $item) {
                        $stream = fopen($_FILES[$this->content]['tmp_name'][$i], 'r');

                        $this->instance->writeStream($path . '/' . $_FILES[$this->content]['name'][$i], $stream);

                        $this->filename[] = $_FILES[$this->content]['name'][$i];
                        $this->success = true;

                        $i = $i + 1;
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

    function download($file, $name = '')
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="' . $file . '"');
        readfile($file);
    }
}
