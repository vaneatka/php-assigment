Feature: Persist data to database
  As a User
  In order to persist data to database
  I pass it to handler

  Scenario:
    Given We gave a valid "file.json" to be processed
    And   The contents are persisted to database
    When  We will get Maps we get aan array
    Then  The file entity status is "processed"
