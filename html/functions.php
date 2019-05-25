<?php
function escape($str){
    preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$newstr);
    $ar = $newstr[0];
    $reString = "";
    foreach($ar as $k=>$v){
        if(ord($ar[$k])>=127) {
            $tmpString=bin2hex(iconv("GBK","ucs-2//IGNORE",$v));
            if (!eregi("WIN",PHP_OS)){
                $tmpString = substr($tmpString,2,2).substr($tmpString,0,2);
            }
            $reString.="%u".$tmpString;
        } else {
            $reString.= rawurlencode($v);
        }
    }
    return $reString;
}

function getMIME($str) {
    switch (strtolower($str)) {
        case 'jpg':
        case 'jpeg':
            return 'image/jpeg';
            break;
        case 'png':
            return 'image/png';
            break;
        case 'gif':
            return 'image/gif';
            break;
        case 'bmp':
            return 'image/bmp';
            break;
        case 'tif':
        case 'tiff':
            return 'image/tiff';
            break;
        default:
            return NULL;
            break;
    }
}