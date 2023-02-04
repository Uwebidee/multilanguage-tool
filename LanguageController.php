<?php

class Controller_LanguageController
{

    public $languageFileArray;
    public $language;
    public $dirpath;

    public function __construct($language = 'en', $dirpath)
    {
        $this->dirpath = $dirpath;
        $this->language = $language;
        $this->selectLanguageFile();
    }

    // public function selectLanguageFile()
    // {
    //     if ($this->language != 'en') {
    //         //require_once $this->dirpath . '/src/inc/lang/lang.' . $this->language . '.php';

    //         $languageArray = json_decode('[{' . file_get_contents($this->dirpath . '/src/inc/lang/lang.' . $this->language . '.php') . '}]');

    //         //var_dump((array) $languageArray[0]); die();
    //         $this->languageFileArray = (array) $languageArray[0];
    //         //var_dump($this->languageFileArray);die();
    //     }
    // }

    public function selectLanguageFile()
    {
        if ($this->language != 'en') {
            $langFile = $this->dirpath . '/src/inc/lang/lang.' . $this->language . '.php';

            $fileHandle = fopen($langFile, 'r');
            while (!feof($fileHandle)) {

                $content = trim(fgets($fileHandle));
                if (empty($content) || $content == null || $content == '' || substr($content, 0, 1) != '"') {
                    continue;
                }

                $content = str_replace('"', '', $content);
                $expl = explode('|', $content);

                $this->languageFileArray[$expl[0]] = $expl[1];
            }
            fclose($fileHandle);
        }
    }

    public function getSelectedTranslation($replace)
    {
        if ($this->language != 'en') {
            return $this->replaceSpecialCharater(str_replace($replace, $this->languageFileArray[$replace], $replace));
        }
        return $this->replaceSpecialCharater($replace);
    }

    public function replaceSpecialCharater($a)
    {
        $a = str_replace('ä', '&auml;', $a);
        $a = str_replace('ö', '&ouml;', $a);
        $a = str_replace('ü', '&uuml;', $a);
        $a = str_replace('Ä', '&Auml;', $a);
        $a = str_replace('Ö', '&Ouml;', $a);
        $a = str_replace('Ü', '&Uuml;', $a);
        $a = str_replace('ß', '&szlig;', $a);
        // $a = str_replace('', '', $a);
        // $a = str_replace('', '', $a);
        // $a = str_replace('', '', $a);
        // $a = str_replace('', '', $a);
        // $a = str_replace('', '', $a);

        return $a;
    }
}
