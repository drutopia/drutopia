Feature: Check that default content is on the front page

  Scenario: A visitor can see the organization description on the front page.
    Given I am on the homepage
    Then I should see "This is where you should write a brief (one to two sentence) description of your organization."

  @api
  Scenario: An editor can reach the about page from the front page.
    Given I am logged in as an Editor
    And I am on the homepage
    When I click "Learn more"
    Then I should see the heading "About"
    And I should see "Drutopia is democratic! Support the project and shape its future by becoming a member."
    And the url should match "about"

  @api
  Scenario: An editor can edit the about page
    Given I am logged in as an Editor
    And I am at "/about"
    # This follows the unexpected edit link
    # When I click "Edit"
    # Then the url should match "node/29/edit"
    # Then I should see "Edit Basic page"
