<?php
namespace Application\Backend\Controllers;

use Application\Backend\Entity\Company;
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
     * @Get("/companies", name="admin.companies")
     */
    public function companiesAction()
    {
        $builder = $this->modelsManager->createBuilder()
            ->addFrom('Application\Backend\Entity\Company', 'c')
            ->orderBy('c.name ASC');

        $this->view->pager = $this->createPager($builder);
    }

    /**
     * @Get("/", name="admin.dashboard")
     */
    public function dashboardAction()
    {
        $stats = new \stdClass();
        $stats->registeredUsers = new \stdClass();
        $stats->registeredUsers->all = User::count();
        $stats->registeredUsers->male = User::count('gender="male"');
        $stats->registeredUsers->female = User::count('gender="female"');
        $stats->registeredUsers->unknown = User::count('gender="unknown"');
        $this->view->stats = $stats;
    }

    /**
     * @Get("/users/stats", name="admin.users.stats")
     */
    public function usersStatsAction()
    {

        $query = $this->modelsManager->createQuery("SELECT u.gender, u.firstName as name, COUNT(*) as cnt FROM Application\Backend\Entity\User u GROUP BY u.firstName ORDER BY cnt DESC");
        $users = $query->execute(array(
            "cache" => array("key" => "my-cache", "lifetime" => 300)
        ));

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
        $builder = $this->modelsManager->createBuilder()
            ->addFrom('Application\Backend\Entity\User', 'u')
            ->orderBy('u.lastName ASC, u.firstName ASC');

        $this->view->pager = $this->createPager($builder);

        $this->view->groupList = $this->modelsManager->createBuilder()
            ->columns(array('g.id', 'g.name as text', 'g.info'))
            ->addFrom('Application\Backend\Entity\Group', 'g')
            ->orderBy('g.name')
            ->getQuery()
            ->execute()
            ->toArray();

        $this->view->groups = Group::find(['order' => 'name']);

        $this->view->roleList = array(
            array('id' => 'ROLE_USER', 'text' => 'Użytkownik'),
            array('id' => 'ROLE_ADMIN', 'text' => 'Administrator'),
            array('id' => 'ROLE_SUPERADMIN', 'text' => 'Superadministrator'),
        );

        $yaml = new \Symfony\Component\Yaml\Yaml();
        $roles = $yaml->parse(file_get_contents(APPLICATION_PATH . '/config/security.yml'));

        $this->view->roles = $roles['security']['role_hierarchy'];
    }

    /**
     * @Post("/{model}/update-parameter", name="admin.update_parameter")
     */
    public function updateParameterAction($model)
    {
        $data = array();
        $fields = array(
            'name',
            'enabled', 'firstName', 'lastName', 'email', 'expires_at', 'info', 'groups', 'roles');

        $id = intval($this->request->getPost('pk', 'int'));
        $parameter = $this->request->getPost('name', ['trim', 'striptags', 'string', 'null']);
        $value = $this->request->getPost('value', ['trim', 'striptags', 'string', 'null']);

        $class = sprintf('Application\Backend\Entity\%s', $model);

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

            if ($object instanceof User or $object instanceof Company) {
                if ($parameter === 'groups') {
                    $value = is_array($value) ? $value : array_filter(array($value), function ($e) {
                        return $e !== null;
                    });
                    $value = array_map(function ($e) {
                        return Group::findFirst($e);
                    }, $value);
                    $object->userGroups->delete();
                }

                if ($parameter === 'roles') {
                    $value = is_array($value) ? $value : array_filter(array($value), function ($e) {
                        return $e !== null;
                    });
                }
            }

            $method = 'set' . ucfirst($parameter);
            if(in_array($method, get_class_methods($class))) {
                $object->$method($value);
            }
            else {
                $object->$parameter = $value;
            }

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

        return $this->sendJson($value);
    }
}
