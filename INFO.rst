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

Delete branch
~~~~~~~~~~~~~

    $ git branch -d hotfix

Show branches
~~~~~~~~~~~~~

    $ git branch

Switch to specific branch
~~~~~~~~~~~~~~~~~~~~~~~~~

    $ git checkout hotfix
    $ git checkout master

Show diff beetween branches
~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $ git checkout master
    $ git merge hotfix

Merge branch
~~~~~~~~~~~~

    $ git checkout master
    $ git merge hotfix

Undo merge branch
~~~~~~~~~~~~~~~~~

    $ git reset --hard origin/master






