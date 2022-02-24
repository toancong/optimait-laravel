<?php
namespace Optimait\Laravel\Services\Image\Resize;

use Optimait\Laravel\Services\Image\Resize\Contracts\SourceInterface;
use Illuminate\Support\Facades\Storage;

class Source implements SourceInterface
{
    private $source;
    private $sourceFileName;
    private $sourceFolder;
    private $disk;

    public function __construct($imagePath, $disk = NULL)
    {
        $this->source = $imagePath;
        $this->sourceFileName = basename($this->source);
        $this->sourceFolder = dirname($this->source);
        $this->disk = $disk;
    }

    public function getSourcePath()
    {
        return $this->source;
    }

    public function getSourceFileName()
    {
        return $this->sourceFileName;
    }

    public function getSourceFolder()
    {
        return $this->sourceFolder;
    }

    public function getDisk()
    {
        $disk = $this->disk ? $this->disk : config('resize.source_disk');
        return Storage::disk($disk);
    }

    public function getOriginalDisk()
    {
        return Storage::disk($this->disk);
    }
}
