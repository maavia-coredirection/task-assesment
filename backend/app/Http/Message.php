<?php


namespace App\Http;


class Message
{

    const CREATE_USER = "User has been created successfully.";
    const INVALID_EMAIL_PASSWORD = "Incorrect email and password";
    const PRODUCT_DELETE_MESSAGE = "Product has been deleted successfully.";
    const PRODUCT_NOT_FOUND = "Product not found";
    const USER_NOT_FOUND_AGAINST_EMAIL = "We cannot find a user with that e-mail address.";
    const RESET_PASSWORD_EMAIL = "We have e-mailed your password reset link!";
    const INVALID_RESET_LINK = "This password reset token is invalid.";
    const INVALID_PASSWORD_UPDATE_TOKEN = "This password reset token is invalid.";

}
