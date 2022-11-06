<?php

namespace TrSearchAndReplace\Text;

class Replace extends Ekler
{
    private $capital = ['Ğ', 'Ç', 'Ş', 'Ü', 'Ö', 'İ', 'I'];
    private $minuscule = ['ğ', 'ç', 'ş', 'ü', 'ö', 'i', 'ı'];



    private function tr_strtolower($str)
    {
        $tr = str_replace($this->capital, $this->minuscule, $str);
        return mb_strtolower($tr, 'UTF-8');
    }

    private function tr_strtoupper($str)
    {
        $tr = str_replace($this->minuscule, $this->capital, $str);
        return mb_strtoupper($tr, 'UTF-8');
    }

    private function parseWords($text, $search, $replace){
        $search = trim($search);
        $search = explode(' ', $search);

        if (is_array($search)){
            foreach ($search as $c){
                $variant = $this->all($c);
                foreach ($variant as $ek => $value){
                    $regex =  $this->str_search_regex($value);
                    $text = preg_replace($regex, $this->isim($replace)->$ek(), $text);
                }
                $text = preg_replace($this->str_search_regex($c), $replace, $text);
            }

        }

        return $text;
    }

    public function regexCharIf($par)
    {
        $par = $this->tr_strtolower($par);

        $minuscule = $this->minuscule;
        $en = ['g', 'c', 's', 'u', 'o', 'i', 'ı'];
        if (in_array($par, $minuscule)) {
            $c = $par;

            if ($par === 'i') $c = 'ı';
            if ($par === 'ı') $c = 'i';
            $reIf[] = str_replace($minuscule, $en, $c);
            $reIf[] = $this->tr_strtoupper(str_replace($minuscule, $en, $c));
        }
        if (ctype_alpha($par) || in_array($par, $this->minuscule)){
            $reIf[] = $par;
            $reIf[] = $this->tr_strtoupper($par);
        }

        //ekler birleştirici
        if ($par == '"' || $par == "'" || $par == "’"){
            $reIf[] = '"';
            $reIf[] = '\'';
            $reIf[] = '’';
            $reIf[] = ' ';
            $reIf[] = '(?!\s)';
        }

        return implode('|', $reIf);
    }

    private function str_search_regex($str)
    {
        //kelime sonu
        $endOfContentR = '(?![[a-zA-Z0-9ğüşöçİĞÜŞÖÇıI])';
        $str = mb_strtolower($this->tr_strtolower($str), 'UTF-8');
        $regex = '/\b(';
        foreach (mb_str_split($str) as $c) {
            $regex .= '(?:' . $this->regexCharIf($c) . ')';
        }
        $regex .= $endOfContentR;
        $regex .= ')\b/m';
        echo $regex.PHP_EOL;
        return $regex;
    }

    public function searchAndReplace($text, $search, $replace)
    {
        return $this->parseWords($text, $search, $replace);
    }

}
