<?php

const SUPER_ADMIN_ROLE = 'super_admin';
const ADMIN_ROLE = 'admin';
const CUSTOMER_ROLE = 'customer';
const DSA_ROLE = 'dsa';
const FO_ROLE = 'fo';
const MANAGER_ROLE = 'manager';
const RELATIONAL_MANAGER_ROLE = 'relational_manager';
const STAFF_ROLE = 'staff';
const TECH_TEAM_ROLE = 'tech_team ';

const ROLES = [
    SUPER_ADMIN_ROLE,
    ADMIN_ROLE,
    CUSTOMER_ROLE,
    DSA_ROLE,
    FO_ROLE,
    MANAGER_ROLE,
    RELATIONAL_MANAGER_ROLE,
    STAFF_ROLE,
    TECH_TEAM_ROLE,
];

const GENDERS = [
    'male',
    'female',
    'others'
];

const BANK_TYPES = [
    'bank',
    'nbfc',
    'fi'
];

const TASK_PRIORITY = [
    'low',
    'medium',
    'high'
];

const PER_PAGE_DEFAULT = 100;

// Response Message
const RESPONSE_STATUS = 'status';
const RESPONSE_MESSAGE = 'message';
const RESPONSE_CODE = 'code';
const RESPONSE_DATA = 'response';
const RESPONSE_ERRORS = 'errors';

const USERNAME_AND_PASSWORD_INCORRECT_MESSAGES = 'Your username was entered incorrectly, or your password was incorrect';
const AUTH_CONFIRMED_MESSAGES = "Confirmed! You're in!";
const SERVER_ERROR_OCCURRED = "Server Error Occurred";

const RETRIEVAL_SUCCESSFUL = "Retrieval Successful";
const CREATED_SUCCESSFUL = "Created Successful";
const EDITED_SUCCESSFUL = "Edited Successful";
const UPDATED_SUCCESSFUL = "Updated Successful";
const DELETED_SUCCESSFUL = "Deleted Successful";