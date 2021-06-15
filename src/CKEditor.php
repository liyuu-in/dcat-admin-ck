<?php

namespace Liyuu\DcatAdminCk;

use Dcat\Admin\Form\Field;

class CKEditor extends Field
{
    protected $view = 'dcat-ck::ckeditor';

    public function render()
    {

        $this->addVariables([
            'filebrowserUploadUrl' => route('ckfinder-connector'),
            'filebrowserBrowseUrl' => route('ckfinder-browser'),
        ]);

        return parent::render();
    }
}
