
Feature: Parse file
  As a User
  In order to persist data to database
  File should be loaded and converted to associative array

  Scenario: Parse Csv File
    Given a "file.csv" to be parsed
    When  the "file.csv" is parsed
    Then  the result was an array

