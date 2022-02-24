<?php

namespace Optimait\Laravel\Services\PdfExport;


use App;

class PdfExportService
{
    private $exporter;
    private $exportedFileName = null;
    private $exportPath = './uploads/attachments/';
    private $isStream = false;

    /**
     * @return boolean
     */
    public function isStream()
    {
        return $this->isStream;
    }

    public function getExporter()
    {
        return $this->exporter;
    }

    /**
     * @param boolean $isStream
     */
    public function setStream($isStream)
    {
        $this->isStream = $isStream;
        return $this;
    }


    public function __construct()
    {
        $this->exporter = App::make('dompdf.wrapper');
    }

    public function setName($name)
    {
        $this->exportedFileName = $name;
        return $this;
    }

    public function getExportedFileName()
    {
        return $this->exportedFileName;
    }

    public function getExportedFullPath()
    {
        return $this->exportPath . $this->exportedFileName;
    }

    /**
     * @return mixed
     */
    public function getExportPath()
    {
        return $this->exportPath;
    }

    /**
     * @param mixed $exportPath
     */

    public function setExportPath($exportPath)
    {
        $this->exportPath = $exportPath;
        return $this;
    }


    public function remove()
    {
        return @unlink($this->getExportedFullPath());
    }

    public function load($content)
    {
        $this->exporter->loadHTML($content);
        return $this;
    }


    public function save(\Closure $c = null)
    {
        if (!is_null($c)) {
            $c($this);
        }

        if (is_null($this->exportedFileName)) {
            $this->exportedFileName = 'Reports_' . time() . '.pdf';
        }
        @$this->exporter->setWarnings(false)->save($this->exportPath . $this->exportedFileName);


        return true;
    }

    public function stream()
    {
        return $this->exporter->download($this->exportedFileName);
    }

    public function download()
    {
        return $this->exporter->download($this->exportedFileName);
    }

} 