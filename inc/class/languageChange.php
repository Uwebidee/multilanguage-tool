<?php

class languageChange
{
    //  Key and replaceword
    public $keyWord;
    public $replaceWord;

    //  Contains all lines from the language file (OLDVERSION)
    public $languageFileArray;

    public $keyArray;
    public $replaceArray;

    //  Contains the language code (en, de, cz....)
    public $language;

    //  Contains the folder path of the index.php
    public $indexPath;

    //  Contains the path to the language file /inc/lang/lang.[en].php
    public $langFilePath;

    //  Call the constuctor and set the language code
    public function __construct($language = 'en')
    {
        //  Set the Language code
        $this->language = $language == null ? 'en' : $language;
    }

    //  Set paths and load the language file
    public function setOptions($indexPath, $langFilePath = '/inc/lang/', $keyWord = 'lid', $replaceWord = 'lstr')
    {
        //  Set the paths
        $this->indexPath = $indexPath;
        $this->langFilePath = $langFilePath;

        //  Set key and replacewords
        $this->keyWord = $keyWord;
        $this->replaceWord = $replaceWord;

        //  Load the language file
        $this->selectLanguageFile();
    }

    //  Load the language file if the language code ist not en
    public function selectLanguageFile()
    {
        //  Run only when the language code ist not en
        if ($this->language != 'en') {

            //  Create string with the language file
            $langFile = $this->indexPath . $this->langFilePath . 'lang.' . $this->language . '.php';


            //  Open the file, read line for line and save the data into keyArray and replaceArray
            $fileHandle = fopen($langFile, 'r');
            while (!feof($fileHandle)) {

                $content = trim(fgets($fileHandle));

                if (trim(substr($content, 0, strlen($this->keyWord))) ==  $this->keyWord) {
                    $contWhitespaceQuote = strlen($this->keyWord) + 2;
                    $this->keyArray[] = substr($content, $contWhitespaceQuote, -1);
                }

                if (trim(substr($content, 0, strlen($this->replaceWord))) ==  $this->replaceWord) {                    
                    $contWhitespaceQuote = strlen($this->replaceWord) + 2;
                    $this->replaceArray[] = substr($content, $contWhitespaceQuote, -1);
                }
            }
            fclose($fileHandle);

            //  test the length of the arrays
            if (count($this->keyArray) === count($this->replaceArray)) {
                //  Save the data into the languageFileArray
                for ($i = 0; $i < count($this->keyArray); $i++) {
                    $this->languageFileArray[$this->keyArray[$i]] = $this->replaceArray[$i];
                }
            } else {
                die('There is an error in the language file.');
            }
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
        foreach ($replaceArray as $key => $value) {
            $a = str_replace($key, $value, $a);
        }
        return $a;
    }


    //  Creates an change link for the demo
    public function returnForDemo()
    {
        $link = '<a href="?lang=de">Change to German</a>';
        if ($this->language == 'de') {
            $link =  '<a href="?lang=en">Wechsle zu Englisch</a>';
        }
        return $link . '<br><br>';
    }
}
