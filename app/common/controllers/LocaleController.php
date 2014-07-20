<?php
namespace Application\Common\Controllers;

class LocaleController extends CommonController
{
    /**
     * Set locale
     *
     * @Get("/locale/{locale:[a-z]{2}}", name="locale")
     */
    public function indexAction($locale)
    {
        $request = new \Phalcon\Http\Request();
        $response = new \Phalcon\Http\Response();

        $this->session->set('locale', $locale);

        $ref = $request->getHTTPReferer();

        if (!empty($ref)) {
            return $response->redirect($ref);
        }

        return $response->redirect();
    }
}
