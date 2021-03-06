Feature: Dashboard Add

  Scenario: Visiting the Add Dashboard page
    Given I am logged in
    And I am on "/dashboard"
    Then I should see "Add"
    When I follow "Add"
    Then I should see "Add Dashboard"

  Scenario: Add Dashboard validation error
    Given I am logged in
    And I am on "/dashboard/add"
    And I press "Save"
    Then I should see "Add Dashboard"
    And I should see 2 ".glyphicon-exclamation-sign" elements

  Scenario: Add Dashboard Default Theme
    Given I am logged in
    And I am on "/dashboard/add"
    And I fill in "dashboard_name" with "behat-test-github"
    And I fill in "dashboard_repository" with "DashboardHub/PipelineDashboard"
    And I press "Save"
    Then I should see "Your Dashboards"
    And I should see "MockUser"
    And I should see "behat-test-github"

  Scenario: Add Dashboard Select a Theme
    Given I am logged in
    And I am on "/dashboard/add"
    And I fill in "dashboard_name" with "behat-test-githubtravis"
    And I fill in "dashboard_repository" with "DashboardHub/PipelineDashboard"
    And I fill in "dashboard_theme" with "DashboardHubAppBundle:Template:GithubTravis.html.twig"
    And I press "Save"
    Then I should see "Your Dashboards"
    And I should see "MockUser"
    And I should see "behat-test-githubtravis"
