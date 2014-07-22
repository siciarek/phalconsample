<?php
namespace Application\Common\Plugin;

/**
 * Enables the cache for a view if the latest
 * executed action has the annotation @Cache
 */
class SecurePlugin extends \Phalcon\Mvc\User\Plugin
{
    /**
     * This event is executed before every route is executed in the dispatcher
     */
    public function beforeExecuteRoute($event, $dispatcher)
    {
        $annotationsDir = APPLICATION_PATH . '/cache/annotations/';
        if (!is_dir($annotationsDir)) {
            mkdir($annotationsDir, 0777, true);
        }
//        $reader = $this->config->application->env !== 'prod'
//            ? new \Phalcon\Annotations\Adapter\Files(array('annotationsDir' => $annotationsDir))
//            : new \Phalcon\Annotations\Adapter\Memory();

        $reader = new \Phalcon\Annotations\Adapter\Files(array('annotationsDir' => $annotationsDir));
        $reader = new \Phalcon\Annotations\Adapter\Memory();

        $required = array();
        $assigned = array();

        // Parse the annotations in the current controller class
        $class = $reader->get($dispatcher->getActiveController())->getClassAnnotations();

        // Parse the annotations in the method currently executed
        $method = $reader->getMethod(
            $dispatcher->getActiveController(),
            $dispatcher->getActiveMethod()
        );

        if ($class !== false and $class->has('Secure')) {
            if (is_array($class->get('Secure')->getArguments())) {
                $required = array_merge($required, $class->get('Secure')->getArguments());
            }
        }

        if ($method !== false and $method->has('Secure')) {
            if (is_array($method->get('Secure')->getArguments())) {
                $required = array_merge($required, $method->get('Secure')->getArguments());
            }
        }

        if (count($required) === 0) {
            return true;
        }

        $user = $dispatcher->getDi()->get('auth')->getUser();

        if ($user !== null) {
            $assigned = $user->roles;
        }

        $intersect = array_intersect($assigned, $required);
        sort($required);
        sort($intersect);
        $granted = $required === $intersect;

        if ($granted === false) {
            $this->view->disable();

            $scheme = $this->request->getServer('REQUEST_SCHEME');
            $host = $this->request->getServer('HTTP_HOST');
            $uri = $this->request->getServer('REQUEST_URI');
            $referer = sprintf('%s://%s%s', $scheme, $host, $uri);

            $this->session->set('referer', $referer);

            $this->flash->warning('user.error.access_denied');

            return $this->response->redirect(array('for' => 'login'))->send();
        }

        return true;
    }
}