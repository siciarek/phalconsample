<?php
/**
 * Phalcon Framework
 * This source file is subject to the New BSD License that is bundled
 * with this package in the file docs/LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@phalconphp.com so we can send you a copy immediately.
 *
 * @author Nikita Vershinin <endeveit@gmail.com>
 */
namespace Application\Common\Paginator\Pager\Layout;

use Phalcon\Paginator\Pager\Layout;

/**
 * \Phalcon\Paginator\Pager\Layout\Bootstrap
 * Pager layout that uses Twitter Bootstrap styles.
 */
class Bootstrap extends Layout
{

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $template = '<li><a href="{%url}">{%page}</a></li>';
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $selectedTemplate = '<li class="active"><span>{%page}</span></li>';

    /**
     * {@inheritdoc}
     *
     * @param  array $options
     * @return string
     */
    public function getRendered(array $options = array())
    {
        $pager =<<<DIV
<div class="row">
    <div class="col-xs-12">
        <form class="navbar-form navbar-left" style="margin-top: 20px">
            <div class="form-group">
            <input style="width:80px" value="{$this->pager->getCurrentPage()}" name="page" class="form-control" type="number"/>
            </div>
            <input type="submit" class="btn btn-default" value="GO"/>
        </form>
        %s
    </div>
</div>
DIV;


        $result = '<ul class="pagination pull-right">';
        $originTemplate = $this->selectedTemplate;
        $bootstrapSelected = '<li class="disabled"><span>{%page}</span></li>';

        if ($this->pager->getCurrentPage() > 1) {
            $this->addMaskReplacement('page', $this->pager->getFirstPage(), true);
            $options['page_number'] = $this->pager->getFirstPage();
            $result .= $this->processPage($options);

            $this->selectedTemplate = $bootstrapSelected;

            $this->addMaskReplacement('page', '&laquo;', true);
            $options['page_number'] = $this->pager->getPreviousPage();
            $result .= $this->processPage($options);
        }

        $this->selectedTemplate = $originTemplate;
        $this->removeMaskReplacement('page');
        $result .= parent::getRendered($options);

        if ($this->pager->getCurrentPage() < $this->pager->getLastPage()) {
            $this->selectedTemplate = $bootstrapSelected;

            $this->addMaskReplacement('page', '&raquo;', true);
            $options['page_number'] = $this->pager->getNextPage();
            $result .= $this->processPage($options);

            $this->addMaskReplacement('page', $this->pager->getLastPage(), true);
            $options['page_number'] = $this->pager->getLastPage();
            $result .= $this->processPage($options);
        }

        $result .= sprintf('<li><span>%d/%d</span></li>', $this->pager->getCurrentPage(), $this->pager->getLastPage());

        $result .= '</ul>';

        return sprintf($pager, $result);
    }
}
