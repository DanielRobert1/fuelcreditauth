<?php

/**
 * ===========================================
 * APP ENV constants
 * ===========================================
 */

 const APP_ENVIRONMENT_LOCAL = 'local';
 const APP_ENVIRONMENT_PRODUCTION = 'production';
 const APP_ENVIRONMENT_STAGING = 'staging';
 const APP_ENVIRONMENT_TESTING = 'testing';


 /**
 * ===========================================
 * Timezone constants
 * ===========================================
 */

const DEFAULT_APP_TIMEZONE = 'Africa/Lagos';
const DEFAULT_LOCATION = 'international';



 /**
 * ===========================================
 * HTTP Codes constants
 * ===========================================
 */

const HTTP_STATUS_OK = \Illuminate\Http\Response::HTTP_OK;
const HTTP_STATUS_CREATED = \Illuminate\Http\Response::HTTP_CREATED;
const HTTP_STATUS_BAD_REQUEST = \Illuminate\Http\Response::HTTP_BAD_REQUEST;
const HTTP_STATUS_UNAUTHENTICATED = \Illuminate\Http\Response::HTTP_UNAUTHORIZED;
const HTTP_STATUS_FORBIDDEN = \Illuminate\Http\Response::HTTP_FORBIDDEN;
const HTTP_STATUS_NOT_FOUND = \Illuminate\Http\Response::HTTP_NOT_FOUND;
const HTTP_STATUS_INTERNAL_SERVER_ERROR = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
const HTTP_STATUS_VALIDATION_ERROR = \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY;



/**
 * ===========================================
 * Authorization constants
 * ===========================================
 */

 const API_AUTH_GUARD = 'sanctum';
 const AUTH_GUARD = 'user';
 const UNKNOWN_DEVICE_TOKEN = 'Unknown Device';
 const DEFAULT_AUTH_GUARD = AUTH_GUARD;


 