<?php
function tokenizing($text)
{
    $words = preg_split('/[ .,:;&>="!?(){}]/', $text);
    return implode(', ', $words);
}
?>