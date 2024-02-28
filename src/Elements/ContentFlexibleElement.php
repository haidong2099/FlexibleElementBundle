<?php

namespace Guave\FlexibleElementBundle\Elements;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\FilesModel;

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

        if (defined('TL_MODE') && TL_MODE === 'BE') {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new BackendTemplate($this->strTemplate);

            $this->Template->title = $this->flexibleTitle;
            $this->Template->wildcard = $this->flexibleSubtitle;

            return $this->Template->parse();
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
        $images = [];

        if (is_string($obj->$attr)) {
            $imagesArr = unserialize($obj->$attr);

            foreach ($imagesArr as $image) {
                $images[] = static::getImageData(FilesModel::findByUuid($image));
            }

            $obj->$attr = $images;
        } else {
            if (is_array($obj->$attr)) {
                return $obj->$attr;
            }
        }

        return $images;
    }

    public static function getImageData(&$objModel)
    {
        if (!$objModel) {
            return;
        }

        if (!$objModel instanceof FilesModel) {
            return;
        }
        if (!defined('TL_ROOT')) {
            define('TL_ROOT', $_SERVER['DOCUMENT_ROOT']);
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

        return [];
    }
}
