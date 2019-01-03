<?php
if (empty($argv[1])) {
    // If no search term is given, notify the user
    echo "Please provide a search term." . PHP_EOL;
} else {
    // Search term entered
    $search_term = $argv[1]; 
    
    // Search term is at least two words long
    if (isset($argv[2])) {
        foreach ($argv as $key => $word) {
            if ($key > 1) {
                $search_term = $search_term . '+' . $word;
            }
        }
    }
    
    $languages = array();
    $total_pages = 1;
    for ($i = 1; $i <= $total_pages; $i++) {
        // Query GitHub for the repositories
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/search/repositories?utf8=%E2%9C%93&q=%22".$search_term."%22+in:description&per_page=100&page=".$i);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = (array)json_decode(curl_exec($ch));
        curl_close($ch);
        
        // If more than 1000 results are found, limit to first 1000
        $total_pages = ceil($output['total_count'] / 100);
        if ($total_pages > 10) $total_pages = 10;
        
        // Increase appropriate language counter in $languages array
        foreach ($output['items'] as $repo) {
            if (!empty($repo->language)) {
                // Repositories with empty "language" fields are ignored
                if (isset($languages[$repo->language])) {
                    $languages[$repo->language] = $languages[$repo->language]+1;
                } else {
                    $languages[$repo->language] = 1;
                }
            }
        }
    }
    
    // Sort the $languages array with greatest value first
    arsort($languages);
    
    // Output results to command line as specified
    foreach ($languages as $key => $value) {
        echo $key . ': ' . $value . PHP_EOL;
    }
    echo '=> ' . $output['total_count'] . ' total result(s) found' . PHP_EOL;
}