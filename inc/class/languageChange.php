<?php

class languageChange
{
    public $languageFileArray;  //  Contains all lines from the language file
    public $language;   //  Contains the language code (en, de, cz....)
    public $indexPath;  //  Contains the folder path of the index.php
    public $langFilePath;   //  Contains the path to the language file /inc/lang/lang.[en].php

    //  Call the constuctor and set the language code
    public function __construct($language = 'en')
    {
        //  Set the Language code
        $this->language = $language == null ? 'en':$language;
    }

    //  Set paths and load the language file
    public function getPaths($indexPath, $langFilePath = '/inc/lang/')
    {
        //  Set the paths
        $this->indexPath = $indexPath;
        $this->langFilePath = $langFilePath;

        //  Load the language file
        $this->selectLanguageFile();
    }

    //  Load the language file if the language code ist not en
    public function selectLanguageFile()
    {
        if ($this->language != 'en') {
            $langFile = $this->indexPath . $this->langFilePath . 'lang.' . $this->language . '.php';

            //  Open the file, read line for line and save the data into $this->languageFileArray[$key] = $value;
            $fileHandle = fopen($langFile, 'r');
            while (!feof($fileHandle)) {

                //  Continue the Line, if there is not a ( " )
                $content = trim(fgets($fileHandle));
                if (substr($content, 0, 1) != '"') {
                    continue;
                }
                $content = str_replace('"', '', $content);
                $expl = explode('|', $content);

                $this->languageFileArray[$expl[0]] = $expl[1];
            }
            fclose($fileHandle);
        }
    }

    //  Replace the language from english to...
    public function getSelectedTranslation($replace)
    {
        if ($this->language != 'en') {
            return $this->replaceSpecialCharacter(str_replace($replace, $this->languageFileArray[$replace], $replace));
        }
        return $this->replaceSpecialCharacter($replace);
    }

    //  Replace characters, you can define whatever you want
    public function replaceSpecialCharacter($a)
    {
        $a = htmlspecialchars($a, ENT_QUOTES, 'UTF-8', true);

        $replaceArray = array(
            '<' => '&lt;',
            '>' => '&gt;',
            'ä' => '&auml;',
            'ö' => '&ouml;',
            'ü' => '&uuml;',
            'Ä' => '&Auml;',
            'Ö' => '&Ouml;',
            'Ü' => '&Uuml;',
            'ß' => '&szlig;',
            '\n' => '<br>',
            '©' => '&copy;',
            '®' => '$reg;',
            '&lt;b&gt;' => '<b>',
            '&lt;/b&gt;' => '</b>'
        );

        foreach($replaceArray as $key => $value) {
            $a = str_replace($key, $value, $a);
        }

        return $a;
    }

    //  Creates an change link for the demo
    public function returnForDemo() {
        $link = '<a href="?lang=de">Change to German</a>';
        if($this->language == 'de') {
            $link =  '<a href="?lang=en">Wechsle zu Englisch</a>';
        }
        return $link . '<br><br>';
    }
}
