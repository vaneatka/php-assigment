
Feature: Parse file
  As a User
  In order to persist data to database
  File should be loaded and converted to associative array

  Scenario: Parse Csv File
    Given a "data/file.csv" to be parsed
    When  the "file.csv" is parsed
    Then  the result was an array


  Scenario: When file come the status is "pending" and is in queue
    Given a "data/file.csv" to be parsed
    When  the "file.csv" is parsed
    Then  the result was an array

