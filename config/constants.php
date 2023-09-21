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

const LOAN_STATUS_DRAFT = 'draft';
const LOAN_STATUS_APPLIED = 'applied';
const LOAN_STATUS_LEAD = 'lead';
const LOAN_STATUS_IN_PROGRESS = 'in_progress';
const LOAN_STATUS_ON_HOLD = 'on_hold';
const LOAN_STATUS_REINITIATED = 'reinitiated';
const LOAN_STATUS_APPROVED = 'approved';
const LOAN_STATUS_REJECTED = 'rejected';
const LOAN_STATUS_DISBURSED = 'disbursed';

const LOAN_STATUS = [
    LOAN_STATUS_DRAFT,
    LOAN_STATUS_APPLIED,
    LOAN_STATUS_LEAD,
    LOAN_STATUS_IN_PROGRESS,
    LOAN_STATUS_ON_HOLD,
    LOAN_STATUS_REINITIATED,
    LOAN_STATUS_APPROVED,
    LOAN_STATUS_REJECTED,
    LOAN_STATUS_DISBURSED,
];


const TASK_PRIORITY = [
    'low',
    'medium',
    'high'
];

const HOME_STATUS = [
    'rental',
    'owned',
    'parental',
    'company_provided'
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
const SEND_INTEREST_SUCCESSFUL = "We appreciate your interest. We'll get in touch with you soon.";
const ALREADY_SEND_INTEREST = "Thank you for your interest. However, you have already expressed interest; we'll contact you shortly.";
