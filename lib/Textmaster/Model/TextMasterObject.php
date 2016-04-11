<?php

namespace Textmaster\Model;

interface TextMasterObject
{
    /**
     * @return string
     */
    public function getTextMasterId();

    /**
     * @param string $textMasterId
     *
     * @return TextMasterObject
     */
    public function setTextMasterId($textMasterId);
}
