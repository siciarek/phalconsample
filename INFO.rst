Useful commands
---------------

Create model with phalcon
=========================

`my_model_name` will be camelized to `MyModelName`

.. code-block:: bash

    vendor\phalcon\devtools\phalcon.bat model \
    company_revenue \
    --force \
    --name=company_revenue \
    --get-set \
    --excludefields="session_id,created_at" \
    --namespace=Application\Backend\Entity \
    --output=app/backend/models/Application/Backend/Entity

.. code-block:: bat

    vendor\phalcon\devtools\phalcon.bat model my_company_revenue --force --name=company_revenue --get-set --namespace=Application\Backend\Entity --output=app\backend\models\Application\Backend\Entity

Show git repo history
=====================

rich

.. code-block:: bash

    $ git log

brief

.. code-block:: bash

    $ git log --pretty=oneline


Git tags support
================

Let us assume that our release has name "v1.0.0"

Create tag
~~~~~~~~~~

.. code-block:: bash

    $ git tag -a v1.0.0 -m "The very first release of the Application."

List tags
~~~~~~~~~

.. code-block:: bash

    $ git tag

Remove tag
~~~~~~~~~~

local

.. code-block:: bash

    $ git tag -d v1.0.1

remote

.. code-block:: bash

    $ git push origin :refs/tags/v1.0.1




Git branches support
====================

Let us assume that branch is named "hotfix".

Create branch
~~~~~~~~~~~~~

Run single command

.. code-block:: bash

    $ git checkout -b hotfix

or two

.. code-block:: bash

    $ git branch hotfix
    $ git checkout hotfix

then send it to remote server

.. code-block:: bash

    $ git push --set-upstream origin hotfix

Delete branch
~~~~~~~~~~~~~

local

.. code-block:: bash

    $ git branch -d hotfix

remote

.. code-block:: bash

    $ git push origin --delete hotfix

Show branches
~~~~~~~~~~~~~

.. code-block:: bash

    $ git branch

Switch to specific branch
~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    $ git checkout hotfix
    $ git checkout master

Show diff beetween branches
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Implicit diff

.. code-block:: bash

    $ git diff master..hotfix

Name and status

.. code-block:: bash

    $ git diff --name-status master..hotfix

More info

.. code-block:: bash

    $ git diff --stat  master..hotfix


Merge branch
~~~~~~~~~~~~

.. code-block:: bash

    $ git checkout master
    $ git merge hotfix

Undo merge branch
~~~~~~~~~~~~~~~~~

.. code-block:: bash

    $ git reset --hard origin/master


Patch branch
~~~~~~~~~~~~

.. code-block:: bash

    $ git diff --no-prefix master..hotfix > diff.patch
    $ patch < diff.patch

Access to branches
~~~~~~~~~~~~~~~~~~

    https://www.kernel.org/pub/software/scm/git/docs/howto/update-hook-example.txt
