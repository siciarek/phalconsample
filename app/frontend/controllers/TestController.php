<?php
namespace Application\Frontend\Controllers;

use Application\Common\Controllers\CommonController;

class TestController extends CommonController
{
    /**
     * @Get("/test/{id:[1-9]\d*}/{activity:(create|update|delete)}", name="test")
     * @Secure(ROLE_USER)
     */
    public function testAction($id, $activity)
    {
        $content = sprintf('%d:%s', $id, $activity);

        $this->view->disable();
        $this->response->setContent($content);
        return $this->response->send();
    }
}
