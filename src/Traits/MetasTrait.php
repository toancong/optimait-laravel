<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 9/8/16
 * Time: 2:35 PM
 */

namespace Optimait\Laravel\Traits;


trait MetasTrait
{
    private $metasContainer = null;

    public function getMeta($key)
    {
        if (is_null($this->metasContainer)) {
            if ($this->metas):
                foreach ($this->metas as $meta) {
                    $unserialized = @unserialize($meta->meta_value);
                    if ($unserialized !== false) {
                        $this->metasContainer[$meta->meta_key] = $unserialized;
                    } else {
                        $this->metasContainer[$meta->meta_key] = $meta->meta_value;
                    }
                }
            endif;
        }
        if (isset($this->metasContainer[$key])) {
            return $this->metasContainer[$key];
        }

        if ($key == 'all') {
            return $this->metasContainer;
        }

        return null;

    }


    public function saveMetas($metaAr, $delete = false)
    {
        if (!empty($metaAr)) {
            $insAr = [];
            foreach ($metaAr as $k => $v) {
                /*if ($v == '') {
                    continue;
                }*/
                if ($delete) {
                    $this->deleteMetaByKey($k);
                }
                $insAr[] = $this->getMetaModel([
                    'meta_key' => $k,
                    'meta_value' => is_array($v) ? serialize($v) : $v
                ]);
            }
            $this->metas()->saveMany($insAr);
        }
    }


    public function deleteMetaByKey($k)
    {
        $this->metas()->where('meta_key', 'LIKE', $k)->delete();
    }

    public function renewMetas($metaAr)
    {
        if (!empty($metaAr)) {
            $this->metas()->delete();
            $this->saveMetas($metaAr);
        }
    }

    public function syncMeta($metaAr)
    {
        if (!empty($metaAr)) {
            $this->saveMetas($metaAr, true);
        }

    }
}