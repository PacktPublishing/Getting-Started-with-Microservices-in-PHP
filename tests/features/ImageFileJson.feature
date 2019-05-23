Feature: Image File JSON

  Scenario: As a user I would like to be able to get a restful response when calling the image json url
    When I issue a "GET" request to "/image/url/default_user.jpg"
    Then The Response Code will be "200"
    Then The Response Will be JSON