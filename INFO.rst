Useful commands
---------------

    vendor\phalcon\devtools\phalcon.bat model company --get-set --force --namespace=\Application\Backend\Entity --name=Company --output=app/backend/models/Application/Backend/Entity

Git tags support
================

Let us assume that our release has name "v1.0.0"

Create tag
~~~~~~~~~~

    $ git tag -a v1.0.0 -m "The very first release of the Application."

List tags
~~~~~~~~~

    $ git tag

Remove tag
~~~~~~~~~~

local

    $ git tag -d v1.0.1

remote

    $ git push origin :refs/tags/v1.0.1




Git branches support
====================

Let us assume that branch is named "hotfix".

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

Access to branches
~~~~~~~~~~~~~~~~~~

    https://www.kernel.org/pub/software/scm/git/docs/howto/update-hook-example.txt