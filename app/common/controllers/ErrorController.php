<?php
namespace Application\Common\Controllers;

class ErrorController extends CommonController
{
    /**
     * @Get("/error-404", name="error_exception_404")
     */
    public function exception404Action()
    {

    }

    /**
     * @Get("/error-500", name="error_exception_500")
     */
    public function exception500Action()
    {

    }
}
