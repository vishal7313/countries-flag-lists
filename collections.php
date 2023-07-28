<!DOCTYPE html>
<html>
    <head>
        <title>List of all countries banknote in my collection</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/api_calls/countries-flag-lists/assets/css/country-lists.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <?php
                $countries_data = file_get_contents('countries.json');
                $all_countries = json_decode($countries_data, true);

                $collections = file_get_contents('collections.json');
                $all_collections = json_decode($collections, true);
                $count = 0;
                
                // Decode the JSON file
                foreach ($all_collections as $key => $value) {
                    foreach ($all_countries as $k => $v) {
                        if ($value['name'] === $v['name']) {
                            $no_times_printed = $value['currency']['total_banknote'];
                            $iso_country = strtolower($v['isoAlpha2']);

                            for ($i = 0; $i < $no_times_printed; $i++) {
                                if ($count > 3) { //col-sm-3 only contains 4 column
                                    echo <<<HTML
                                        </div>
                                        <div class="row">
                                    HTML;
                                    $count = 0;
                                }
                                $currency_code_or_symbol = !empty($v['currency']['symbol']) ? $v['currency']['symbol'] : $v['currency']['code'];
                                echo <<<HTML
                                    <div class="col-sm-3" style="border: 1px solid #E34342">
                                        <img
                                            src="/api_calls/countries-flag-lists/assets/flags/{$iso_country}.svg"
                                            alt="{$v['name']}"
                                            height="55"
                                            width="55"
                                            style="border-color: #0658A7;"
                                        />
                                        <span>
                                            <a href="https://en.wikipedia.org/wiki/{$v['name']}">{$v['name']} </a>
                                            - {$v['currency']['name']} {{$currency_code_or_symbol}}
                                        </span>
                                    </div>
                                HTML;
                                $count++;
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>