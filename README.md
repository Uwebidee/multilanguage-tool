# Multilanguage-tool
Version: 1.0.1

A little tool to make your Website/Web App/Homepage Multilingual.

See into "/inc/lang/lang.de.php" to see the formate of der language file.

To use the tool in your project:

1 include the languageChange.php in your project
2 Initialize $translator = new languageChange($setLanguageTo);
3 Set the options $translator->setOptions($indexPath, $langFilePath, $keyWord, $replaceWord);
4 Call the translate $translator->getSelectedTranslation('Welcome to the Code-Demo');
