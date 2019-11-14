
Feature: Parse file
  As a User
  In order to persist data to database
  File should be loaded and converted to associative array

  Scenario: Parse XML File
    Given a "file.xml" to be parsed
    When  the "file.xml" is parsed
    Then  the result was an array


