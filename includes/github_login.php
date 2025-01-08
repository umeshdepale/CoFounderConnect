<?php
session_start();

// GitHub OAuth configuration
$client_id = ''; // Replace with your GitHub Client ID
$redirect_uri = 'https://umeshdepale.com/cofounder/includes/github_callback.php'; // Replace with your callback URL
$scope = 'read:user user:email'; // Permissions
$state = bin2hex(random_bytes(16)); // Generate a random state for security

// Save state in session
$_SESSION['oauth_state'] = $state;

// Redirect to GitHub's OAuth login page
$github_authorize_url = "https://github.com/login/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&state=$state";

header("Location: $github_authorize_url");
exit();
?>
