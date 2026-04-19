<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

$app = new yii\web\Application($config);
// Dump alias and assetManager info for debugging asset path issues
try {
	$info = [
		'@webroot' => Yii::getAlias('@webroot'),
		'@web' => Yii::getAlias('@web'),
		'assetManager.basePath' => isset($app->assetManager) ? $app->assetManager->basePath : null,
		'assetManager.baseUrl' => isset($app->assetManager) ? $app->assetManager->baseUrl : null,
	];
	@file_put_contents(__DIR__ . '/../runtime/alias_debug.log', var_export($info, true));
} catch (Throwable $e) {
	@file_put_contents(__DIR__ . '/../runtime/alias_debug.log', 'error: ' . $e->getMessage());
}

// run application
 $app->run();
