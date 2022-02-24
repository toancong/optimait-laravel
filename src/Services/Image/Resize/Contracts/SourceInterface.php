<?php

namespace Optimait\Laravel\Services\Image\Resize\Contracts;


interface SourceInterface
{
    public function getSourcePath();

    public function getSourceFileName();

    public function getSourceFolder();

    public function getDisk();
}