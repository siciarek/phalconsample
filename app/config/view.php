<?php

class Volt extends \Phalcon\Mvc\View\Engine\Volt
{
    public function getCompiler()
    {
        if (empty($this->_compiler)) {
            parent::getCompiler();
            $this->partial('macros');
        }

        $compiler = parent::getCompiler();

        $compiler->addFilter('merge', 'array_merge');
        $compiler->addFilter('md5', 'md5');
        $compiler->addFilter('date', function($resolvedArgs, $exprArgs) {
            $a = explode(',' ,$resolvedArgs);
            return 'date(' . $a[1] . ', strtotime(' . $a[0] .'))';
        });

        return $compiler;
    }
}

// Register Volt as a service
$di->set('volt', function ($view, $di) {

    $cacheBaseDir = APPLICATION_PATH . $di->get('config')->dirs->cache . '/volt';

    $options = array(
        'compiledPath' => function ($templatePath) use ($cacheBaseDir) {

            $sep = '/';

            // Remove ../app/views from $templatePath
            $temp = explode($sep, $templatePath);
            $temp = array_slice($temp, 1);
            $templatePath = implode($sep, $temp);

            // Create cached file path
            $cachedFilePath = sprintf('%s/%s.php', $cacheBaseDir, $templatePath);

            // Create cached file subdirectory if not exists
            $cacheDir = preg_replace('|[^/]+$|', '', $cachedFilePath);

            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0777, true);
            }

            return $cachedFilePath;
        },
        'compileAlways' => $di->get('config')->application->env === 'dev',
    );

    $volt = new Volt($view, $di);
    $volt->setOptions($options);

    return $volt;
});


$view = new Phalcon\Mvc\View();

// Register Volt as template engine

$di->setShared('view', function () use ($view) {

    $view->registerEngines(array(
        '.volt' => 'volt'
    ));

    return $view;
});
