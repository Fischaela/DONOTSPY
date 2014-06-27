# DONOTSPY

Simple mail server application with email address verification and encrypted database. 

## Setup

1. Copy dist directory to your server.
2. Point domain/documents folder to /dist/puplic
3. Setup datbase with fields according to /dist/application/models/message.php
4. configure in dist/application/config/
    - mail.php: E-Mail recipient
    - encryption.php: Your key for database encryption
    - database.php: Connection to your database

## History

### Version 0.2

#### 0.2.3
Removed a typo

#### 0.2.2
Social Media
- Added social media sharing links (without including social media scripts)
- Grammar improvements
- Meta data
- JavaScript bugfixing

#### 0.2.1
Hotfix
- Link to data privacy statement
- data privacy statement content

#### 0.2.0

Imroved Basic security 

- basic database encryption of sender, recipient, subject and text
- compatibility with browsers without javascript (removed angular, added jquery for progressive enhancement)

### Version 0.1

#### 0.1.0

Initial Version with

- Angular frontend app
- CodeIgniter mail and database application
