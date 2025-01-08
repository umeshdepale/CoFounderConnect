<?php
session_start();

// Validate state parameter
if ($_GET['state'] !== $_SESSION['oauth_state']) {
    die('Invalid state parameter.');
}

// Exchange the authorization code for an access token
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $client_id = ''; // Replace with your GitHub Client ID
    $client_secret = ''; // Replace with your GitHub Client Secret

    // GitHub API for access token
    $url = 'https://github.com/login/oauth/access_token';
    $data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
    ];

    // Make POST request to GitHub
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    // Parse the response
    parse_str($response, $result);

    if (isset($result['access_token'])) {
        $access_token = $result['access_token'];

        // Get user data from GitHub API
        $user_url = 'https://api.github.com/user';
        $headers = [
            "Authorization: token $access_token",
            "User-Agent: YourAppName", // Replace with your app name
        ];
        $user_context = stream_context_create(['http' => ['header' => $headers]]);
        $user_data = json_decode(file_get_contents($user_url, false, $user_context), true);

        // Save user data in session
        $_SESSION['g_user_id'] = $user_data['id'];
        $_SESSION['g_full_name'] = $user_data['login'] ?? $user_data['login'];

        // Redirect to your main page
        header('Location: https://umeshdepale.com/cofounder/apply.php?t_id='.$_SESSION['t_id']);
        exit();
    } else {
        die('Failed to get access token.');
    }
} else {
    die('No authorization code provided.');
}
?>
