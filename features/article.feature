Feature: Article
  In order to use the application
  I need to be able to create and get and delete articles trough the API.

  @createSchema
  Scenario: Create new Article
    Given I add "Accept" header equal to "application/json"
    And I add "Content-type" header equal to "application/json" 
    When i send a "POST" request to "/articles" with body:
    """
      { "title": "title 1", "leading" : "leading test", "body": "test body", "createdBy": "toto" }
    """
    Then the response status code should be 201
    And the response should be in JSON

  Scenario: Retrieve one Article
    When I send a "GET" request to "/articles/title-1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "title" should be equal to "title 1"
    And the JSON node "leading" should be equal to "leading test"
    And the JSON node "body" should be equal to "test body"
    And the JSON node "created_by" should be equal to "toto"

  Scenario: Retrieve all Articles
    When I send a "GET" request to "/articles"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"

  @dropSchema
  Scenario: Remove one Article
    When i send a "DELETE" request to "/articles/title-1"
    Then the response status code should be 204
    And i send a "GET" request to "/articles/title-1"
    Then the response status code should be 404