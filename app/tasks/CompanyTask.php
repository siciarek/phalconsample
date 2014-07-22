<?php

use  Faker\Provider\pl_PL\Person;
use  Faker\Provider\pl_PL\Internet;

class CompanyTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
        $limit = 200;

        $first_name = null;
        $last_name = null;
        $email = null;
        $users = [];

        $generator = \Faker\Factory::create('pl_PL');

        foreach (range(1, $limit) as $i) {
            $c = new \Application\Backend\Entity\Company();
            $c->setEnabled(1);
            $c->setName($generator->company);
            $c->setInfo($generator->paragraph(2));
            $c->save();

            echo '.';

            foreach ($c->getMessages() as $m) {
                var_dump($m->getMessage());
            }
        }
    }

    private function toAscii($string)
    {
        $from = array('ą', 'Ą', 'ć', 'Ć', 'ę', 'Ę', 'ł', 'Ł', 'ó', 'Ó', 'ś', 'Ś', 'ż', 'Ż', 'ź', 'Ź', 'ń', 'Ń');
        $to = array('a', 'A', 'c', 'C', 'e', 'E', 'l', 'L', 'o', 'O', 's', 'S', 'z', 'Z', 'z', 'Z', 'n', 'n');

        return str_replace($from, $to, $string);
    }
}
