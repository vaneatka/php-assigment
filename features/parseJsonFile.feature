
Feature: Parse file
  As a User
  In order to persist data to database
  File should be loaded and converted to associative array

  Scenario: Parse JSON File
    Given a "file.json" to be parsed
    When  the "file.json" is parsed
    Then  the result was an array

