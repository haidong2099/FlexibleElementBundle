<?php

namespace Guave\FlexibleElementBundle\Elements;

use Contao\ContentElement;
use FilesModel;
use Image;

class ContentFlexibleElement extends ContentElement
{
    /** @var string */
    protected $strTemplate = 'ce_flexibleelement';

    /**
     * {@inheritDoc}
     */
    protected function compile(): void
    {
        $this->Template->flexibleImage = self::prepareImages($this, 'orderSRC');
    }

    /**
     * {@inheritDoc}
     */
    public function generate(): string
    {
        if ($this->customTpl) {
            $tmplStr = str_replace('.html5', '', $this->customTpl);
        } else {
            $tmpl    = static::getTemplateByLayout($this->elementTemplate);
            $tmplStr = $tmpl['template'];
        }

        $this->strTemplate = $tmplStr;

        if (TL_MODE === 'BE') {
            if ($tmpl !== null) {
                return '<div><span>FlexibleElement</span><br><br>'.Image::getHtml(
                    static::getIconPath().'/'.$tmpl['id'].$GLOBALS['TL_FLEXIBLEELEMENT']['iconExt']
                ).'</div>';
            }

            return '<div><span>FlexibleElement</span><br><br>'.$tmplStr.'</div>';
        }

        return parent::generate();
    }

    public static function getIconPath()
    {
        global $GLOBALS;

        return $GLOBALS['TL_FLEXIBLEELEMENT']['iconPath'];
    }

    /**
     * @deprecated
     */
    public static function getBackendMap()
    {
        $base      = static::getIconPath();
        $arr       = [];
        $templates = &$GLOBALS['TL_FLEXIBLEELEMENT']['templates'];
        foreach ($templates as $tmpl) {
            $arr[] = $base.$tmpl['id'];
        }

        return $arr;
    }

    public static function getTemplateByLayout($layout)
    {
        $templates = &$GLOBALS['TL_FLEXIBLEELEMENT']['templates'];
        foreach ($templates as $tmpl) {
            if ($tmpl['id'] === $layout) {
                return $tmpl;
            }
        }

        return null;
    }

    public static function prepareImages(&$obj, $attr)
    {
        if (is_string($obj->$attr)) {
            $images    = [];
            $imagesArr = unserialize($obj->$attr);
            foreach ($imagesArr as $image) {
                $images[] = static::getImageData(FilesModel::findByUuid($image));
            }

            $obj->$attr = $images;
        } else if (is_array($obj->$attr)) {
            return $obj->$attr;
        }

        return $images;
    }

    public static function getImageData(&$objModel)
    {
        if (!$objModel) {
            return;
        }

        if (!$objModel instanceof \Contao\FilesModel) {
            return;
        }

        if ($objModel) {
            if (!is_file(TL_ROOT.'/'.$objModel->path)) {
                //try to load from s3
                //S3::loadFileFromS3($objModel->path);
            }
        }
        if (is_file(TL_ROOT.'/'.$objModel->path)) {

            $meta = unserialize($objModel->meta);
            $meta = $meta[$GLOBALS['TL_LANGUAGE']];

            return [
                'src'   => $objModel->path,
                'name'  => $objModel->name,
                'title' => $meta['title'] ? $meta['title'] : $objModel->name,
            ];
        }

        return null;
    }
}
