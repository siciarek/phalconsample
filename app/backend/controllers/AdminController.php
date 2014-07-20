<?php
namespace Application\Backend\Controllers;

use Phalcon\Mvc\Model\Message;

use Application\Common\Controllers\CommonController;
use Application\Backend\Entity\User;
use Application\Backend\Entity\Group;

/**
 * @RoutePrefix("/admin")
 * @Secure(ROLE_ADMIN)
 */
class AdminController extends CommonController
{
    /**
     * @Get("/", name="admin.dashboard")
     */
    public function dashboardAction()
    {

    }

    /**
     * @Get("/users/stats", name="admin.users.stats")
     */
    public function usersStatsAction()
    {

        $query = $this->modelsManager->createQuery("SELECT u.gender, u.firstName as name, COUNT(*) as cnt FROM Application\Backend\Entity\User u GROUP BY u.firstName ORDER BY cnt DESC");
        $users = $query->execute();

        $names = array();

        foreach ($users as $user) {
            @$names[$user->gender][] = array('name' => $user->name, 'count' => $user->cnt);
        }

        $this->view->user_female_names = $names['female'];
        $this->view->user_male_names = $names['male'];
    }

    /**
     * @Get("/users", name="admin.users")
     */
    public function usersAction()
    {
        $curr_page = intval($this->request->get('page'));

        $builder = $this->modelsManager->createBuilder()
            ->addFrom('Application\Backend\Entity\User', 'u')
            ->orderBy('u.lastName ASC, u.firstName ASC');

        $paginator = new \Application\Common\Paginator(array(
            'builder' => $builder,
            'limit' => $this->config->pager->size,
            'page' => $curr_page,
        ));

        $this->view->page = $paginator->getPaginate($this->config->pager->length);
        $this->view->groupList =  $this->modelsManager->createBuilder()
            ->columns(array('g.id', 'g.name as text'))
            ->addFrom('Application\Backend\Entity\Group', 'g')
            ->orderBy('g.name')
            ->getQuery()
            ->execute()
            ->toArray()
        ;
    }

    /**
     * @Post("/update-parameter", name="admin.update_parameter")
     */
    public function updateParameterAction()
    {
        $data = array();
        $fields = array('enabled', 'firstName', 'lastName', 'email', 'expires_at', 'info', 'groups');

        $id = intval($this->request->getPost('pk', 'int'));
        $parameter = $this->request->getPost('name', ['trim', 'striptags', 'string', 'null']);
        $value = $this->request->getPost('value', ['trim', 'striptags', 'string', 'null']);

        $class = 'Application\Backend\Entity\User';

        $object = new $class();

        if (!in_array($parameter, $fields)) {

            $message = new Message(
                $this->di->get('trans')->query('common.error.field_is_not_supported', array('field' => $parameter))
            );

            $object->appendMessage($message);

        } else {

            if (in_array($parameter, array('first_name', 'last_name'))) {
                $value = $this->request->getPost('value', ['trim', 'title', 'null']);
            }

            if (in_array($parameter, array('email'))) {
                $value = $this->request->getPost('value', ['trim', 'email', 'lower', 'null']);
            }

            $object = $class::findFirst($id);

            if ($parameter === 'groups' and $object instanceof User) {
                $value = is_array($value) ? $value : array_filter(array($value), function($e){ return $e !== null; });
                $value = array_map(function($e){ return Group::findFirst($e);}, $value);
                $object->userGroups->delete();
            }

            $object->$parameter = $value;

            $object->save();
        }

        $messages = $object->getMessages();

        if (count($messages) > 0) {
            $data = array();
            foreach ($messages as $message) {
                $data[] = $this->di->get('trans')->query($message->getMessage());
            }
            return $this->sendJson($data, 'error');
        }

        $data = $object->$parameter ? : '';

        return $this->sendJson($data);
    }
}
