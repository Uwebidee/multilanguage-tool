<?php
$setLanguageTo = 'de';

$dirpath = str_replace('\\', '/', __DIR__);

require_once $dirpath . '/src/inc/func/func.inc.php';
require_once $dirpath . '/src/inc/class/autoloader.php';

//require_once $dirpath . '/src/inc/lang/lang.de.php';
$translate = new Controller_LanguageController($setLanguageTo, $dirpath);

require_once $dirpath . '/src/inc/values.inc.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $translate->getSelectedTranslation('en'); ?>">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="./src/css/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="./src/css/bootstrap.min.css">
  <script src="./src/js/jquery.min.js"></script>
  <script src="./src/js/bootstrap.bundle.min.js"></script>
  <script src="./src/js/jquery.validate.min.js"></script>
  <script src="./src/js/additional-methods.min.js"></script>
  <!-- <script src="./src/js/vali.js"></script> -->
  <title><?php echo sprintf($translate->getSelectedTranslation('%s %s - &copy; 2023 - %s by %s'), definedVars('PROGRAMTITLE'), definedVars('PROGRAMVERSION'), definedVars('ACTUALLYYEAR'), definedVars('PUBLISHER')); ?></title>
</head>

<body class="text-bg-dark p-0 m-0">

  <div class="container">
    <h1 class="title"><?php echo sprintf($translate->getSelectedTranslation('Welcome to %s'), definedVars('PROGRAMTITLE')); ?></h1>



    <div class="row">
      <div class="col-sm-8">
        <?php
        require_once $dirpath . '/src/view/index.view.php';
        ?>
      </div>

      <div class="col-sm-3 offset-sm-1">
        <h3><?php echo $translate->getSelectedTranslation('Logs'); ?></h3>
        <p>
        <?php echo $translate->getSelectedTranslation('Previous logs with cURL queries and returns.'); ?>
        </p>
        <ul>
          <?php
          readLogFileDir($dirpath . '/src/logs')
          ?>
        </ul>
      </div>
    </div>

  </div>
</body>

</html>