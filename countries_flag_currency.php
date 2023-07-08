<!DOCTYPE html>
<html>
    <head>
        <title>Countries with Flag and currency</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            @media print {
                .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                    float: left;
                }
                .col-sm-4 {
                    width: 33.33333333%;
                }
                .col-sm-3 {
                    width: 50%;
                }

                a[href]:after {
                    content: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <?php
                $countries_data = file_get_contents('countries.json');
                $count = 0;
                // Decode the JSON file
                $all_countries = json_decode($countries_data, true);
                foreach ($all_countries as $key => $value) {
                    $custom_print = 1; //specific number of time an individual wants to print the country information
                    $iso_country = strtolower($value['isoAlpha2']);

                    if ($iso_country === 'in') {
                        $custom_print = 11;
                    } else if ($iso_country === 'qa' || $iso_country === 'om') {
                        $custom_print = 4;
                    } else if ($iso_country === 'us') {
                        $custom_print = 6;
                    }
                    for ($i = 0; $i < $custom_print; $i++) {
                        if ($count > 3) { //col-sm-3 only contains 4 column
                            echo <<<HTML
                                </div>
                                <div class="row">
                            HTML;
                            $count = 0;
                        }
                        $currency_code_or_symbol = !empty($value['currency']['symbol']) ? $value['currency']['symbol'] : $value['currency']['code'];
                        echo <<<HTML
                            <div class="col-sm-3" style="border: 1px solid #E34342">
                                <img
                                    src="/api_calls/countries_currency_flag/assets/flags/{$iso_country}.svg"
                                    alt="{$value['name']}"
                                    height="55"
                                    width="55"
                                    style="border-color: #0658A7;"
                                />
                                <span>
                                    <a href="https://en.wikipedia.org/wiki/{$value['name']}">{$value['name']} </a>
                                    - {$value['currency']['name']} {{$currency_code_or_symbol}}
                                </span>
                            </div>
                        HTML;
                        $count++;
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>