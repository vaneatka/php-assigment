
Feature: Parse file
  As a User
  In order to persist data to database
  File should be loaded and converted to associative array

  Scenario: Parse Json File
    Given We recieve "file.json" from command line
    And   We recieve "file.json" from Web
    When  I run parse, the result is an array
    Then  The resulted array contain parsed data
