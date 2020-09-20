<?php


namespace App\Alias;


abstract class Routes
{
    const LOGIN            = 'login';
    const LOGOUT           = 'logout';
    const RESET_PASSWORD   = 'reset';
    const CONFIRM_PASSWORD = 'confirm';
    const VERIFY_EMAIL     = 'verify';


    const DASHBOARD = 'dashboard';


    const COMPANIES      = 'companies';
    const COMPANY_NEW    = 'company_new';
    const COMPANY_VIEW   = 'company_view';
    const COMPANY_EDIT   = 'company_edit';
    const COMPANY_SAVE   = 'company_save';
    const COMPANY_DEL    = 'company_del';
    const COMPANY_UPDATE = 'company_update';


    const EMPLOYEES       = 'employees';
    const EMPLOYEE_NEW    = 'employee_new';
    const EMPLOYEE_VIEW   = 'employee_view';
    const EMPLOYEE_EDIT   = 'employee_edit';
    const EMPLOYEE_SAVE   = 'employee_save';
    const EMPLOYEE_DEL    = 'employee_del';
    const EMPLOYEE_UPDATE = 'employee_update';

}