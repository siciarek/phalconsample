<?php

use  Faker\Provider\pl_PL\Person;
use  Faker\Provider\pl_PL\Internet;

class FixturesTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
        $limit = 25000;

        $first_name = null;
        $last_name = null;
        $email = null;
        $users = [];

        $generator = \Faker\Factory::create('pl_PL');

        foreach (range(1, $limit) as $i) {
            $first_name = Faker\Provider\pl_PL\Person::firstNameFemale();
            $last_name = Faker\Provider\pl_PL\Person::lastNameFemale();

            if(rand(0, 1) === 1) {
                $first_name = Faker\Provider\pl_PL\Person::firstNameMale();
                $last_name = Faker\Provider\pl_PL\Person::lastNameMale();
            }

            $prefix = $this->toAscii($first_name);
            $sufix = $this->toAscii($last_name);
            $dot = '.';

            switch(rand(0, 2)) {
                case 1:
                    $prefix = $prefix[0];
                    break;
                case 2:
                    $prefix = $prefix[0];
                    $dot = '';
                    break;
            }

            list($username, $domain) = explode('@', $generator->email);
                $email = sprintf('%s%s%s@%s', $prefix, $dot, $sufix, $domain);

            $email = strtolower($email);
            $users[] = [$first_name, $last_name, $email];
        }

        foreach ($users as $u) {
            $user = new \Application\Backend\Entity\User();
            $user->firstName = $u[0];
            $user->lastName = $u[1];
            $user->email = $u[2];
            $user->gender = preg_match('/a$/', $user->firstName) ? 'female' : 'male';
            $user->password = $this->security->hash('password');

            $user->save();

            $messages = $user->getMessages();

            foreach ($messages as $m) {
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
