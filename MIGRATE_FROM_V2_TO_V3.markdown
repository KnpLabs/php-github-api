Good news! Even if the internal code is much better, the API stays untouched!
Only the main class has changed. Just replace

    $github = new phpGitHubApi(); // old

with

    $github = new Github_Client(); // new

Also you will need to setup autoloading, see instructions in README.
