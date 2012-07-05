Feature: Rate Limit
  In order to get rate limit information
  As an anonymous user
  I need to be able to make calls to /rate_limit resource

  Scenario: Get rate limit
    When I send a request for rate limit information
    Then I should not reach my rate limit
# Commented because GH limit is reset once per hour
#    Then the response should equal to json:
#    """
#    {
#      "rate": {
#        "remaining": 4999,
#        "limit": 5000
#      }
#    }
#    """
