Feature: Drutopia content types
  Makes sure that the content types were created during installation.

  
  Scenario: Make sure that the article content type provided by Drutopia at installation is present.
    Given I am logged in as a user with the administrator role
    When I visit "/node/add"
    Then I should see "Article"

