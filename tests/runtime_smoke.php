<?php
// Run from the repository root: php tests/runtime_smoke.php
error_reporting(E_ALL);
set_error_handler(static function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
define('ROOT', dirname(__DIR__) . '/');
require ROOT . 'vendor/autoload.php';
require ROOT . 'core/ReflexMethod.php';

$target = new class {
    public function echoValue($value) { return $value; }
};
$method = new core\ReflexMethod($target, 'echoValue');
if ($method->invokeArgs($target, ['result']) !== 'result') {
    throw new RuntimeException('Reflection return value lost');
}
$smarty = new Smarty\Smarty();
$compileDir = ROOT . 'temp/smarty-smoke';
if (!is_dir($compileDir)) {
    mkdir($compileDir, 0775, true);
}
$smarty->setCompileDir($compileDir);
$smarty->assign('name', 'myFrame');
if ($smarty->fetch('string:Hello {$name}') !== 'Hello myFrame') {
    throw new RuntimeException('Smarty rendering failed');
}
$config = HTMLPurifier_Config::createDefault();
$config->set('Cache.DefinitionImpl', null);
$purifier = new HTMLPurifier($config);
if ($purifier->purify('<b>safe</b><script>alert(1)</script>') !== '<b>safe</b>') {
    throw new RuntimeException('HTML purification failed');
}
$redis = new Predis\Client();
$key = 'runtime-smoke:' . bin2hex(random_bytes(8));
try {
    $redis->setex($key, 30, 'ok');
    if ($redis->get($key) !== 'ok') {
        throw new RuntimeException('Redis roundtrip failed');
    }
} finally {
    $redis->del([$key]);
}
echo "PASS: reflection return, Smarty rendering, HTML purification, Redis roundtrip (E_ALL)\n";
