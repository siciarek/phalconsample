<?php
namespace Application\Test\Controllers;

use Application\Backend\Entity\Company;
use Application\Common\Controllers\CommonController;


/**
 * @RoutePrefix("/test")
 */
class DefaultController extends CommonController
{
    public function initialize()
    {
        // CSS

        $this->assets
            ->collection('aceheader')
            ->addCss('aceadmin/assets/css/bootstrap.min.css')
            ->addCss('aceadmin/assets/css/font-awesome.min.css')
            ->addCss('aceadmin/assets/css/ace-fonts.css')
            ->addCss('aceadmin/assets/css/ace.min.css');

        $this->assets
            ->collection('aceskins')
            ->addCss('aceadmin/assets/css/ace-skins.min.css')
//            ->addCss('//cdn.datatables.net/1.10.1/css/jquery.dataTables.css', false)
            ->addCss('aceadmin/assets/css/ace-rtl.min.css');

        $this->assets
            ->collection('aceie9')
            ->addCss('aceadmin/assets/css/ace-part2.min.css');

        $this->assets
            ->collection('aceie')
            ->addCss('aceadmin/assets/css/ace-ie.min.css');


        // JAVASCRIPT

        $this->assets
            ->collection('ie8')
            ->addJs('aceadmin/assets/js/html5shiv.js')
            ->addJs('aceadmin/assets/js/respond.min.js');

        $this->assets
            ->collection('aceextra')
            ->addJs('aceadmin/assets/js/ace-extra.min.js');

        $this->assets
            ->collection('footer')
            ->addJs('aceadmin/assets/js/ace/ace.onpage-help.js')
            ->addJs('aceadmin/docs/assets/js/rainbow.js')
            ->addJs('aceadmin/docs/assets/js/language/generic.js')
            ->addJs('aceadmin/docs/assets/js/language/html.js')
            ->addJs('aceadmin/docs/assets/js/language/css.js')
            ->addJs('aceadmin/docs/assets/js/language/javascript.js')
            ->addJs('//cdn.datatables.net/1.10.1/js/jquery.dataTables.js');
    }

    /**
     * @Get("/toggle-status/{model}/{id:[1-9]\d*}", name="test.toggle.status")
     */
    public function toggleStatusAction($model, $id)
    {
        $class = 'Application\Backend\Entity\\' . ucfirst($model);
        $obj = $class::findFirst($id);
        $obj->setEnabled($obj->getEnabled() == 1 ? 0 : 1);
        $obj->save();
        $obj = $class::findFirst($id);

        $this->response->setContentType('application/json');
        $this->response->setContent(json_encode($obj->toArray()));

        return $this->response;
    }

    /**
     * @Get("/companies", name="test.index")
     * @Secure(ROLE_USER)
     */
    public function indexAction()
    {
        $builder = $this->modelsManager->createBuilder()
            ->addFrom('Application\Backend\Entity\Company', 'c')
            ->orderBy('c.name ASC');

        $this->view->initials = Company::getInitials();
        $this->view->pager = $this->createPager($builder);
    }

    /**
     * @Get("/companies/revenue", name="test.revenue")
     * @Secure(ROLE_USER)
     */
    public function revenueAction()
    {
        $builder = $this->modelsManager->createBuilder()
            ->addFrom('Application\Backend\Entity\CompanyRevenue', 'r')
            ->columns(['r.company_id', 'r.workers_count', 'r.revenue'])
            ->orderBy('r.workers_count ASC')
        ;

        $temp = $builder->getQuery()->execute();

        $data = array('workers' => [], 'revenue' => []);

        $c = 0;

        foreach($temp as $r) {
            $data['workers'][] = [$c, $r->workers_count];
            $data['revenue'][] = [$c, $r->revenue];
            $c++;
        }

        $this->view->chartData = $data;
    }

    /**
     * @Get("/companiesx", name="test.companies")
     */
    public function companiesAction()
    {
        $builder = $this->modelsManager->createBuilder()
            ->addFrom('Application\Backend\Entity\Company', 'c')
            ->columns(['c.enabled as status', 'c.name', 'c.info'])
            ->orderBy('c.name ASC');

        $pager = $this->createPager($builder, 'draw');

        $data = array();

        foreach ($pager as $i) {
            $data[] = $i->toArray();
        }

        return $this->sendJson($data, 'data', 'Companies', $pager->count());
    }

    /**
     * @Get("/table", name="test.table")
     */
    public function tableAction()
    {

    }
}
