name: CI Pipeline

on:
  push:
    branches:
      - main
  pull_request:
    branches:
      - main

jobs:
  php-tests:
    runs-on: ubuntu-latest

    env:
      MYSQL_ROOT_PASSWORD: root

    steps:
    # Step 1: Check out the repository
    - name: Checkout Code
      uses: actions/checkout@v3

    # Step 2: Set up PHP environment
    - name: Set up PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        extensions: pdo_mysql

    # Step 3: Configure and Start MySQL
    - name: Start MySQL service
      run: |
        sudo service mysql start
        mysql -u root -p$MYSQL_ROOT_PASSWORD -e "SET GLOBAL sql_mode = 'NO_ENGINE_SUBSTITUTION';"
        mysql -u root -p$MYSQL_ROOT_PASSWORD -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH 'mysql_native_password' BY '$MYSQL_ROOT_PASSWORD'; FLUSH PRIVILEGES;"
        mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE cat_kery;"
        mysql -u root -p$MYSQL_ROOT_PASSWORD cat_kery < ./cat-kery.sql

    # Step 4: Clear Composer Cache and Install Dependencies
    - name: Install Composer Dependencies
      run: |
        composer clear-cache
        rm -rf vendor
        composer install --prefer-dist

    # Step 5: Verify PHPUnit Installation
    - name: Verify PHPUnit Installation
      run: |
        ls vendor/bin
        composer show phpunit/phpunit

    # Step 6: Run PHPUnit Tests
    - name: Run PHPUnit Tests
      run: vendor/bin/phpunit

    # Step 7: Archive Test Results (Optional)
    - name: Upload Test Results
      if: always()
      uses: actions/upload-artifact@v3
      with:
        name: test-results
        path: ./tests/
