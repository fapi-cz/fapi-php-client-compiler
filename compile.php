<?php
declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

\Tracy\Debugger::enable(__DIR__ . '/log');

@umask(0);

$tmpDir = __DIR__ . '/tmp';
$repoDir = __DIR__ . '/repository';

$fileSystem = new \Symfony\Component\Filesystem\Filesystem();
$fileSystem->remove($tmpDir);
$fileSystem->remove($repoDir);

\passthru(
	'git clone git@github.com:fapi-cz/php-client.git' . ' ' . \escapeshellarg($repoDir)
);

\passthru(
	'composer require guzzlehttp/guzzle -d ' . \escapeshellarg($repoDir)
);

\passthru(
	'composer require nette/tester -d ' . \escapeshellarg($repoDir)
);

\passthru(
	'composer install --no-dev -d ' . \escapeshellarg($repoDir)
);

mkdir($tmpDir);

$phar = new Phar($tmpDir . '/fapiClient.phar');

$phar->buildFromDirectory($repoDir);



