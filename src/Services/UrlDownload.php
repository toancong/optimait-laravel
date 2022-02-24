<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 8/15/16
 * Time: 11:08 AM
 */

namespace Optimait\Laravel\Services;


use Curl\Curl;

class UrlDownload
{
    private $isSecure = false;
    private $folder = './uploads/';
    private $filename;
    private $url;
    private $username;
    private $password;
    private $curl;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return UrlDownload
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return UrlDownload
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSecure()
    {
        return $this->isSecure;
    }

    /**
     * @param boolean $isSecure
     * @return UrlDownload
     */
    public function setSecure($isSecure)
    {
        $this->isSecure = $isSecure;
        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     * @return UrlDownload
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     * @return UrlDownload
     */
    public function saveAs($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getFullPath()
    {
        return $this->folder . $this->filename;
    }

    /**
     * @param mixed $url
     * @return UrlDownload
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function __construct($url = '', $filename = '')
    {
        $this->url = $url;
        $this->filename = $filename;
        $this->curl = new Curl();
    }

    public function download()
    {
        /*$curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_HEADER, 0);
        curl_setopt($curl_handle, CURLOPT_URL, $this->getUrl());
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);*/
        /*$curl->setReferrer('');
        $curl->setUserAgent('');*/

        if ($this->isSecure()):
            $this->curl->setBasicAuthentication($this->getUsername(), $this->getPassword());
            /*curl_setopt($curl_handle, CURLOPT_USERPWD, $this->getUsername() . ":" . $this->getPassword());*/
        endif;

        $this->curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $this->curl->setOpt(CURLOPT_FOLLOWLOCATION, true);


        /*$buffer = curl_exec($curl_handle);
        if(!$buffer || $buffer == 'false'){
            throw new \Exception("Invalid Response : ".$buffer);
        }
        //$httpcode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        //echo $httpcode;
        curl_close($curl_handle);*/

        $this->curl->get($this->getUrl());
        if ($this->curl->error) {
            throw new \Exception($this->curl->error_code);
        }
        else {
            if($this->curl->http_status_code != 200){
                throw new \Exception("Invalid Response : Code : ".$this->curl->http_status_code);
            }

            /*var_dump($this->curl->request_headers);
            var_dump($this->curl->response_headers);*/

            /*$header_len = curl_getinfo($this->curl->curl, CURLINFO_HEADER_SIZE);*/
            /*$header = substr($this->curl->curl, 0, $header_len);*/
            /*$body = substr($this->curl->response, $header_len);*/

            file_put_contents($this->getFullPath(), strstr($this->curl->response, 'Online product code'));
        }


    }


    public static function From($url){
        $urlDownload = new UrlDownload($url);
        return $urlDownload;
    }
}