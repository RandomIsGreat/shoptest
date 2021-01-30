<?php
session_start();
if (!isset($defaultGoodsOnPage)&&!isset($defaultGoodsCategory))
{
    $defaultGoodsOnPage = 10;
    $defaultGoodsCategory = "Mask";
} else
