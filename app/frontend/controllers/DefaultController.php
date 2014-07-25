<?php
namespace Application\Frontend\Controllers;

use Application\Common\Controllers\CommonController;
use Application\Backend\Form\UserLoginForm;
use Application\Backend\Entity\User;

class DefaultController extends CommonController
{

    /**
     * @Get("/register", name="user.registration")
     * @Post("/register", name="user.register")
     */
    public function registerAction()
    {
        $user = new User();
        $form = new \Application\Backend\Form\UserRegistrationForm($user);

        if ($this->request->getMethod() === 'POST') {

            $form->bind($_POST, $user);

            if ($form->isValid($_POST)) {

                $user->gender = preg_match('/a$/i', $user->firstName) ? User::GENDER_FEMALE : User::GENDER_MALE;
                $user->password = $this->security->hash($user->password);

                if ($user->save() === true) {
                    $this->auth->authenticate($user);
                    return $this->response->redirect(array('for' => 'index'));
                }
            }
        }

        $this->view->form = $form;
    }
    
    /**
     * @Get("/", name="index")
     */
    public function indexAction()
    {

    }

    /**
     * @Get("/logout", name="logout")
     */
    public function logoutAction()
    {
        $this->auth->logOut();

        $this->flash->notice('user.logged_out_message');

        return $this->response->redirect(array('for' => 'index'));
    }

    /**
     * @Get("/login", name="login")
     * @Post("/login")
     */
    public function loginAction()
    {
        $access = new \stdClass();
        $form = new UserLoginForm($access);

        if ($this->request->getMethod() === 'POST') {
            $form->bind($_POST, $access);
            if ($form->isValid($_POST)) {

                $user = User::findFirstByEmail($access->email);

                if ($user instanceof User and $user->password === $this->security->hash($access->password)) {

                    if ($user->enabled == true and $user->suspended == false) {

                        $this->auth->authenticate($user);

                        $referer = $this->session->get('referer');
                        $this->session->remove('referer');
                        $referer = $referer?:array('for' => 'index');

                        return $this->response->redirect($referer);
                    } else if ($user->enabled == true and $user->suspended == true) {
                        $this->flash->warning('user.error.suspended');
                    } else {
                        $this->flash->warning('user.error.disabled');
                    }
                } else {
                    $this->flash->warning('user.error.invalid_access_data');
                }
            }
        }

        $this->view->form = $form;
    }
}
