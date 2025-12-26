<?php

$file = explode("\n", file_get_contents('2025/ploteczki.txt'));
$pattern = '/^\d{1,2}\.\d{2}\.20\d{2},\s+\d{2}:\d{2}\s+-\s+(.+?):/';
$userCounts = [];
$msgs = array_filter($file, function ($line) use ($pattern, &$userCounts) {
    if (preg_match($pattern, $line, $matches)) {
        $username = $matches[1];
        $userCounts[$username] = ($userCounts[$username] ?? 0) + 1;
        return true;
    }
    return false;
});

arsort($userCounts);
$data = [];
foreach ($userCounts as $username => $count) {
    echo "$username: $count messages\n";
    $data[] = ['profile' => ['username' => $username], 'cnt' => $count];
}

file_put_contents('2025/stats/ploteczki.json', json_encode(['data' => $data]));


