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
            $name = $generator->company;
            $initial = mb_substr($name, 1, 1, 'UTF-8');
            $initial = mb_strtolower($initial, 'UTF-8');

            $c = new \Application\Backend\Entity\Company();
            $c->setEnabled(1);
            $c->setName($name);
            $c->setInitial($initial);
            $c->setInfo($generator->paragraph(2));
            $c->save();

            echo '.';

            $r = new \Application\Backend\Entity\CompanyRevenue();
            $r->setCompanyId($c->getId());
            $r->setWorkersCount(rand(30, 500));
            $r->setRevenue(sprintf('%d.%d', rand(2000, 300000), rand(0, 99)));
            $r->save();

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
