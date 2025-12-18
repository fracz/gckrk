<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$userAvatars = require __DIR__ . '/user_avatars.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <meta name="description" content="Podsumowanie roku 2025"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/reveal.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/theme/night.min.css"
          id="theme"/>

    <!--	<link rel="stylesheet"-->
    <!--		  href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/atelier-cave-light.min.css"-->
    <!--		  integrity="sha512-fNprY9f5BGeuC3KYaGc0+fAke3ZIFpsUXTMsqg2Bi2c7F/ktzTnutNkzNmq3izYkr2ke+/pyBpNsZbk1tA9OZw=="-->
    <!--		  crossorigin="anonymous" />-->

    <title>Geocachingowe podsumowanie roku 2025 - Kraków</title>

    <style>
        div.chart {
            height: 600px;
        }

        .dark-block {
            padding: 15px 50px;
            background: rgba(0, 43, 54, 0.7);
        }

        .dark-block a {
            color: gold;
        }

        .big {
            font-size: 2em;
        }

        .bigger {
            font-size: 4em !important;
        }

        .fragment.blur {
            filter: blur(20px);
        }

        .fragment.blur.visible {
            filter: none;
        }

        .avatar {
            width: 200px;
            height: 200px;
            border-radius: 20%;
        }

        .number {
            color: gold;
            font-weight: bold;
            font-size: 2em;
        }

        .r-stack img:nth-child(2) {
            margin-left: -180px;
            margin-top: -30px;
        }

        .r-stack img:nth-child(3) {
            margin-right: -180px;
            margin-top: 40px;
        }

        .r-stack img:nth-child(4) {
            margin-left: -60px;
            margin-top: 30px;
        }

        .r-stack img:nth-child(5) {
            margin-right: -60px;
            margin-top: 60px;
        }

        .r-stack img:nth-child(6) {
            margin-left: -70px;
            margin-top: 80px;
        }

        .source a {
            font-size: 0.6em;
            color: #888;
        }

        .smile {
            background-image: url(https://www.geocaching.com/account/app/ui-icons/icons/log-types/2.svg);
            background-size: contain;
            display: inline-block;
            height: .8em;
            width: .8em;
        }

        .reveal blockquote {
            padding: 30px;
        }

        .reveal blockquote.wide {
            width: 1200px;
            font-size: 0.8em;
        }

        .photos h1 {
            font-size: 100px;
            padding: 5px;
            margin: 0;
        }

        .photos h2 {
            font-size: 80px;
        }

        :root {
            --r-heading-text-transform: unset;
        }


        blockquote em {
            text-decoration: underline;
            font-weight: bold;
            color: gold;
        }

    </style>
</head>


<?php

enum SlideType
{
    case MONTH;
    case EVENT;
    case MEMORIES;
    case BAR_CHART;
}

$memories = [
    'kranfagel' => 'pierwsza samodzielnie zdobyta drzewna T5',
    'j_janus' => "Największą radością dla mnie jest wyzwalanie  energii u ludzi do robienia wielkich rzeczy. Sukcesem społecznym roku 2025 jest <em>wydarzenie Mega - Przygody Keszerka</em>. Aktywnością towarzyszącą był największy w Polsce GeoArt z Lab Cache (będąc w Belgii na Atomium zamarzyłem, żeby stworzyć coś podobnego w Polsce), współtworzenie GeoArt Torcik. Cieszy mnie też Cito kajakowe. Nową inicjatywą na tym terenie jest <em>cykl codziennych eventów grudniowych</em>. Dziękuję Wam! \n Prywatnie: publikacja wirtuala Webcam, zagadka 3-D, udział w Giga w Pradze, zdobycie kesza z największą ilością przyznanych rekomendacji na świecie oraz 4 nowe kraje: Szwajcaria, USA, Gwatemala, Kanada. Zobaczyłem też, że <em>mam najczęściej odwiedzanego kesza w województwie, ósmego w Polsce</em>.",
    'Naphilim' => "W tym roku największe wrażenie zrobił na mnie <em>event w Pradze</em>, gdzie nauczyłem się, że \"komu z keszerem w podróż, temu krowa mać large o północy w polu na czeskiej wsi\".\nNiemniej chciałbym przekazać, że <em>jesteście najpozytywnjejszą grupą szaleńców</em> i chciałbym podziękować, że przygarnęliście młodego i mnie ma doczepkę do waszego grona. Jesteście wspaniali 😀",
];

$slides = [
    [
        ['type' => SlideType::MONTH, 'month' => '01', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB23NB', 'title' => 'GeoPubQuiz 🤔❓', 'owner' => 'Emson_', 'date' => '30 stycznia'],
    ],
    [
        ['type' => SlideType::MEMORIES],
    ],
    [

        ['type' => SlideType::MONTH, 'month' => '02', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2M0V', 'title' => 'Czas na pizze', 'owner' => 'Zuśka_Kluśka', 'date' => '7 lutego'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2TEE', 'title' => 'Przegląd gier terenowych #1 🔍🗺️', 'owner' => 'Emson_', 'date' => '19 lutego'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2TE8', 'title' => 'Czy zjesz ze mną pączusia? 🍩', 'owner' => 'Emson_', 'date' => '27 lutego'],
    ],
    [

        ['type' => SlideType::MONTH, 'month' => '03', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::BAR_CHART, 'stats' => 'top_finders.json', 'title' => 'Znalezienia w Małopolsce'],
    ]
];
?>

<body>
<div class="reveal">
    <div class="slides">

        <section data-markdown>
            <textarea data-template>
                # KRAKOWSKIE
                ## geocachingowe
                ## podsumowanie roku
                # 2025
                ## [GCAW0DT](https://coord.info/GCAW0DT)
                ### Discover me: `CC7FKQ`
            </textarea>
        </section>

        <section data-markdown>
            <textarea data-template>
                *W prezentacji użyłem zdjęć zamieszczonych w listingach opisywanych eventów oraz zdjęć załączonych do logów w tych eventach.*

                *Jeśli Twoim zdaniem jakikolwiek wykorzystany w prezentacji materiał narusza prawa autorskie lub powinien być stąd usunięty z dowolnego innego powodu, proszę o informację.*

                *Jeśli znajdziesz jakiś błąd w treści, to również proszę o kontakt.*

                *Autorem prezentacji jest [kranfagel](https://www.geocaching.com/account/messagecenter?recipientId=49369c87-1a23-4cd6-a054-3c76cf2399f6&gcCode=GCAW0DT).*
            </textarea>
        </section>

        <?php foreach ($slides as $slideColumn): ?>
            <section>
                <?php foreach ($slideColumn as $slide):
                    $folderId = $slide['folder'] ?? $slide['gccode'] ?? '';
                    $coverPath = "images/2025/$folderId/cover.jpg";
                    ?>
                    <?php
                    if ($slide['type'] === SlideType::MONTH):
                        $month = $slide['month'];
                        $firstDay = date('Y-m-d', strtotime('first day of 2025-' . $month));
                        $lastDay = date('Y-m-d', strtotime('last day of 2025-' . $month));
                        $monthNames = [
                            '01' => 'Styczeń',
                            '02' => 'Luty',
                            '03' => 'Marzec',
                            '04' => 'Kwiecień',
                            '05' => 'Maj',
                            '06' => 'Czerwiec',
                            '07' => 'Lipiec',
                            '08' => 'Sierpień',
                            '09' => 'Wrzesień',
                            '10' => 'Październik',
                            '11' => 'Listopad',
                            '12' => 'Grudzień'
                        ];
                        ?>
                        <section>
                            <h1><?= $monthNames[$month] ?></h1>
                            <p><em><?= $slide['subtitle'] ?></em></p>
                            <div class="source">
                                <a href="https://project-gc.com/Tools/MapCompare?player_prc_profileName=kranfagel&geocache_mc_show%5B%5D=found-none&geocache_mc_show%5B%5D=found-one&geocache_mc_show%5B%5D=found-all&geocache_crc_country%5B%5D=Poland&geocache_crc_region%5B%5D=Ma%C5%82opolskie&geocache_crc_region%5B%5D=Podkarpackie&geocache_crc_region%5B%5D=%C5%9Al%C4%85skie&geocache_dae_disabled=on&geocache_dae_archived=on&geocache_dae_pastEvents=on&geocache_ts_type%5B%5D=Cache+In+Trash+Out+Event&geocache_ts_type%5B%5D=Event+Cache&geocache_ts_type%5B%5D=Groundspeak+Lost+and+Found+Celebration&geocache_hd_fromDate=<?= $firstDay ?>&geocache_hd_toDate=<?= $lastDay ?>&submit=Filter"
                                   target="_blank">
                                    źródło
                                </a>
                            </div>
                        </section>
                    <?php
                    elseif ($slide['type'] === SlideType::EVENT):
                        $photos = [];
                        if (file_exists($coverPath)) {
                            $photos = array_values(array_diff(scandir(dirname($coverPath)), ['cover.jpg', '.', '..']));
                        }
                        ?>
                        <section <?= file_exists($coverPath) ? "data-background=\"$coverPath\" data-auto-animate" : '' ?>>
                            <h1 class="dark-block r-fit-text"><?= $slide['title'] ?></h1>
                            <h2 class="dark-block">
                                <a href="https://coord.info/<?= $slide['gccode'] ?>"
                                   target="_blank"><?= $slide['gccode'] ?></a>
                                <?= $slide['date'] ?>
                                <a target="_blank"
                                   href="https://www.geocaching.com/p/?u=<?= $slide['owner'] ?>"><?= $slide['owner'] ?></a>
                            </h2>
                        </section>
                        <?php if (count($photos) > 0): ?>
                        <section data-auto-animate class="photos">
                            <h1 class="dark-block"><?= $slide['title'] ?></h1>
                            <h2 class="dark-block">
                                <a href="https://coord.info/<?= $slide['gccode'] ?>"
                                   target="_blank"><?= $slide['gccode'] ?></a>
                                <?= $slide['date'] ?>
                                <a target="_blank"
                                   href="https://www.geocaching.com/p/?u=<?= $slide['owner'] ?>"><?= $slide['owner'] ?></a>
                            </h2>
                            <div class="r-stack">
                                <?php foreach ($photos as $photo): ?>
                                    <img class="<?= $photo == $photos[0] ? '' : 'fragment' ?>"
                                         src="<?= dirname($coverPath) ?>/<?= $photo ?>" height="600"/>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    <?php elseif ($slide['type'] === SlideType::MEMORIES): ?>
                        <section>
                            <h1>Wspomnienia z 2025</h1>
                        </section>
                        <?php
                        foreach ($memories as $nick => $text):
                            $avatarUrl = $userAvatars[$nick] ?? 'https://geocaching.com/images/default_avatar.png';
                            ?>
                            <section>
                                <h2><a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= urlencode($nick) ?>"><?= htmlspecialchars($nick) ?></a>
                                </h2>
                                <img src="<?= $avatarUrl ?>" class="avatar">
                                <blockquote class="fragment custom blur <?=strlen($text) > 100 ? 'wide' : '' ?>">
                                    <?= nl2br($text) ?>
                                </blockquote>
                            </section>
                        <?php endforeach; ?>
                    <?php elseif ($slide['type'] === SlideType::BAR_CHART):
                        $data = json_decode(file_get_contents(__DIR__ . '/2025/stats/' . $slide['stats']), true);
                        $data = array_slice($data['data'], 0, $slide['top'] ?? 10);
                        $nicks = array_map(fn($row) => $row['profile']['username'], $data);
                        $values = array_map(fn($row) => $row['cnt'], $data);
                        $anonymousData = ['data' => ['labels' => array_map(fn($n) => '?', $nicks), 'datasets' => [['data' => $values]]]];
                        $chartData = ['data' => ['labels' => $nicks, 'datasets' => [['data' => $values]]]];
                        ?>
                        <section data-auto-animate>
                            <h1><?= $slide['title'] ?></h1>
                            <div class="chart">
                                <canvas data-chart="bar">
                                    <!--
                                    <?= json_encode($anonymousData) ?>
                                    -->
                                </canvas>
                            </div>
                            <div style="visibility: hidden">
                                <a>źródło</a>
                            </div>
                        </section>
                        <section data-auto-animate>
                            <h1><?= $slide['title'] ?></h1>
                            <div class="chart">
                                <canvas data-chart="bar">
                                    <!--
                                    <?= json_encode($chartData) ?>
                                    -->
                                </canvas>
                            </div>
                            <div class="source">
                                <a href="https://project-gc.com/Statistics/TopFTF?profile_country=Poland&profile_region=Ma%C5%82opolskie&fromyyyy=2024&frommm=1&fromdd=1&toyyyy=2024&tomm=12&todd=31&submit=Filter"
                                   target="_blank">
                                    źródło
                                </a>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>

        <section data-background="images/2024/other/sad.webp">
            <h1 class=" r-fit-text">KONIEC</h1>
        </section>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/reveal.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/plugin/markdown/markdown.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/plugin/math/math.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/plugin/notes/notes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/5.1.0/plugin/highlight/highlight.js"></script>
<!-- Chart plugin -->
<script src="https://cdn.jsdelivr.net/npm/reveal.js-plugins@latest/chart/plugin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>

    let multiplexSecret = localStorage.getItem('multiplexSecret');
    // multiplexSecret = '17360681015334246426';

    Chart.register(ChartDataLabels);

    Reveal.initialize({
        width: 1280,
        height: 1050,
        controls: true,
        progress: true,
        history: true,
        center: true,

        // IMPORTANT: The order matters!
        // So, RevealHightlight must be the LAST to load
        plugins: [RevealMarkdown, RevealMath, RevealNotes, RevealChart, RevealHighlight],

        chart: {
            defaults: {
                maintainAspectRatio: false,
                responsive: true,
                color: 'lightgray', // color of labels
                font: {size: 35},
                scale: {
                    beginAtZero: true,
                    // ticks: { stepSize: 1 },
                    grid: {color: "#333333"}, // color of grid lines
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: Math.round,
                        font: {
                            weight: 'bold'
                        }
                    },
                    legend: {display: false}
                }
            },
            line: {
                borderColor: ["rgba(20,220,220,.8)", "rgba(220,120,120,.8)", "rgba(20,120,220,.8)"],
                "borderDash": [[5, 10], [0, 0]]
            },
            bar: {backgroundColor: ["rgba(56,172,54,0.8)", "rgba(220,120,120,.8)", "rgba(20,120,220,.8)"]},
            pie: {backgroundColor: [["rgba(0,0,0,.8)", "rgba(220,20,20,.8)", "rgba(20,220,20,.8)", "rgba(220,220,20,.8)", "rgba(20,20,220,.8)"]]},

        },
        // multiplex: {
        //     secret: multiplexSecret, // null so the clients do not have control of the master presentation
        //     id: '75d179b77ef2f85d', // id, obtained from socket.io server
        //     url: 'https://reveal-multiplex.glitch.me/' // Location of socket.io server
        // },
        // dependencies: [
        //     {src: 'https://reveal-multiplex.glitch.me/socket.io/socket.io.js', async: true},
        //     {
        //         src: multiplexSecret ? 'https://reveal-multiplex.glitch.me/master.js' : 'https://reveal-multiplex.glitch.me/client.js',
        //         async: true
        //     }
        // ]
    });
</script>

</body>

</html>
