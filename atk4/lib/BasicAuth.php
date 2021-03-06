<?php // vim:ts=4:sw=4:et:fdm=marker
/*
 * Undocumented
 *
 * @link http://agiletoolkit.org/
*/
/*
==ATK4===================================================
   This file is part of Agile Toolkit 4
    http://agiletoolkit.org/

   (c) 2008-2013 Agile Toolkit Limited <info@agiletoolkit.org>
   Distributed under Affero General Public License v3 and
   commercial license.

   See LICENSE or LICENSE_COM for more information
 =====================================================ATK4=*/
class BasicAuth extends Auth_Basic
{
    function createForm($page)
    {
        $form = $page->add('Form');
        $email = $this->model->hasField($this->login_field);
        $email = $email ? $email->caption : 'Username';
        $password = $this->model->hasField($this->password_field);
        $password = $password ? $password->caption : 'Password';
        $form->addField('Line', 'username', $email);
        $form->addField('Password', 'password', $password);
        $form->addSubmit('Login');
        return $form;
    }
}
