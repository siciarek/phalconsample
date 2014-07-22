Useful commands
---------------

    vendor\phalcon\devtools\phalcon.bat model company --get-set --force --namespace=\Application\Backend\Entity --name=Company --output=app/backend/models/Application/Backend/Entity

Git branches support
====================

New branch is named "hotfix".

Create branch
~~~~~~~~~~~~~

Run single command

    $ git checkout -b hotfix

or two

    $ git branch hotfix
    $ git checkout hotfix

then send it to remote server

    $ git push --set-upstream origin hotfix

Delete branch
~~~~~~~~~~~~~

local

    $ git branch -d hotfix

remote

    $ git push origin --delete hotfix

Show branches
~~~~~~~~~~~~~

    $ git branch

Switch to specific branch
~~~~~~~~~~~~~~~~~~~~~~~~~

    $ git checkout hotfix
    $ git checkout master

Show diff beetween branches
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Implicit diff

    $ git diff master..hotfix

Name and status

    $ git diff --name-status master..hotfix

More info

    $ git diff --stat  master..hotfix


Merge branch
~~~~~~~~~~~~

    $ git checkout master
    $ git merge hotfix

Undo merge branch
~~~~~~~~~~~~~~~~~

    $ git reset --hard origin/master


Patch branch
~~~~~~~~~~~~

    $ git diff --no-prefix master..hotfix > diff.patch
    $ patch < diff.patch
