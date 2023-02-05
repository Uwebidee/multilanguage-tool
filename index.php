<?php
/*
 *  Language Changer v1.0.1
 * 
 */

//  OPTIONS [Start]
//  Complete systempath. str_replace is for Windows...
$indexPath = str_replace('\\', '/', __DIR__);

//  Path to the language file
$langFilePath = '/inc/lang/';

//  Set the seach Keyword and replaceword.
//  If you change the words her, you must be change the words in the language file.
$keyWord = 'lid';
$replaceWord = 'lstr';
//  OPTIONS [End]

//  Change this Variable $setLanguageTo = 'en' (default, english), $setLanguageTo = 'de' (german). If empty = default
//  You can call your own language file over the url https://your-domain.tld/index.php?lang=YOUR-FILENAME (lang.YOUR-FILENAME.php)
//  Please do not use @$_GET['lang'] in your project without a validate.
$setLanguageTo = htmlspecialchars(@$_GET['lang']);

//  Placeholder for sprintf()
$sprintfPlaceholder1 = 'echo $translator->getSelectedTranslation(\'HERE YOUR TEXT\');';
$sprintfPlaceholder2 = 'echo sprintf($translator->getSelectedTranslation(\'This is %s and %s \'), $variable1, $variable2);';

//  Include the language change class
require_once $indexPath . '/inc/class/languageChange.php';

//  Call the Class, for default leave empty
$translator = new languageChange($setLanguageTo);
//  Set the options $indexPath, '/inc/lang/', $keyWord = 'lid', $replaceWord = 'lstr'
$translator->setOptions($indexPath, $langFilePath, $keyWord, $replaceWord);
?>
<!DOCTYPE html>
<html lang="<?php echo $translator->getSelectedTranslation('en'); ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="./src/css/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="./src/css/min.style.css">
  <title><?php echo $translator->getSelectedTranslation('Your Website Title'); ?></title>
</head>
<body>
  <div class="container center">
    <h1 class="title"><?php echo $translator->getSelectedTranslation('Welcome to the Code-Demo'); ?></h1>
    <?php echo $translator->returnForDemo(); ?>
    <div class="content">
      <?php echo sprintf($translator->getSelectedTranslation('Here is a Demonstration about the function of this code with a placeholder and a Linebreak.\n The code you need is\n\n <b>%s</b> \n\n or with sprintf and placeholder\n\n <b>%s</b>'), $sprintfPlaceholder1, $sprintfPlaceholder2); ?>
    </div>
  </div>
</body>
</html>