# App Center API Wrapper for laravel

## Introduction

This is a App Center wrapper library for Laravel. This packages is based on App Center API endpoints located at https://openapi.appcenter.ms, the main intention for this package is for simplified the consume and comunication with tools more used on dev mobile enviroment. You can set a configuration of your product and make calls to methods that envolving parameters and requirements for whole endpoints.

Well, before install this packages, you should make and register an app at https://appcenter.ms/, then you will be create an api token with access like "Full Access" or "Read only" for your apps

## Installation

You'll need to require the package with Composer:

```sh
composer require presi/app-center-laravel
```

Then discovery packages are done, from the command line again, run 

```
php artisan vendor:publish --provider="Presi\AppCenter\AppCenterServiceProvider"
``` 

to publish the default configuration file. 
This will publish a configuration file named `appcenter.php` which includes your Api token and owner name


## Configuration

For complete setup you need to fill in `appcenter.php` file that is found in your applications `config` directory.
`owner_name` is your *Username* and `api_token` which is located at settings account.

## Usage

### Read Analytics Events on App

You can retrive data of events with this code

    $events = AppCenter::readEvents({{app-name}},\Carbon\Carbon::now()->subDays(7));

