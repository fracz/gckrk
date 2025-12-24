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

        .small {
            font-size: 0.6em;
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
    case TITLE;
    case NUMBERS;
    case YOUTUBE;
}

$memories = [
    'kranfagel' => 'pierwsza samodzielnie zdobyta drzewna T5',
    'j_janus' => "Największą radością dla mnie jest wyzwalanie  energii u ludzi do robienia wielkich rzeczy. Sukcesem społecznym roku 2025 jest <em>wydarzenie Mega - Przygody Keszerka</em>. Aktywnością towarzyszącą był największy w Polsce GeoArt z Lab Cache (będąc w Belgii na Atomium zamarzyłem, żeby stworzyć coś podobnego w Polsce), współtworzenie GeoArt Torcik. Cieszy mnie też Cito kajakowe. Nową inicjatywą na tym terenie jest <em>cykl codziennych eventów grudniowych</em>. Dziękuję Wam! \n Prywatnie: publikacja wirtuala Webcam, zagadka 3-D, udział w Giga w Pradze, zdobycie kesza z największą ilością przyznanych rekomendacji na świecie oraz 4 nowe kraje: Szwajcaria, USA, Gwatemala, Kanada. Zobaczyłem też, że <em>mam najczęściej odwiedzanego kesza w województwie, ósmego w Polsce</em>.",
    'Naphilim' => "W tym roku największe wrażenie zrobił na mnie <em>event w Pradze</em>, gdzie nauczyłem się, że \"komu z keszerem w podróż, temu krowa mać large o północy w polu na czeskiej wsi\".\nNiemniej chciałbym przekazać, że <em>jesteście najpozytywnjejszą grupą szaleńców</em> i chciałbym podziękować, że przygarnęliście młodego i mnie ma doczepkę do waszego grona. Jesteście wspaniali 😀",
    'EkaSyr_Mantis' => "Początek 2025 roku – konto EkaSyr, znaleziono 140 skrytek.\n Koniec 2025 roku – konto EkaSyr&Mantis, ponad 2000 skrytek, zebrany matriks, 19 ukrytych, wędka, kalosze, CITO, MEGA, FTF, brudny samochód, dzieci same w domu i wściekle.\n Czy to rodzaj COVIDu geocachingowego?",
    'seba54' => "Obyło się bez zbytnich szaleństw :)\n - milestone 10.000 znalezień celowo na keszu GCA2025 (Where's 25?)\n - utrzymanie ciągłości miesięcznych FTF-ów\n- w końcu pierwszy awatar, pieczątka i osobisty drewniak",
    'm2mPL' => "Udało mi się zrobić 10000 kroków podczas doby spędzonej w busie, w trakcie wycieczki o pieszczotliwym tytule 15 krajów w jeden dzień ;P Kosztowało mnie to troszkę krążenia wokół busa na postojach i biegania do keszy, ale udało się :)\n\nStała się rzecz niesłuchana, byłam świadkiem dwóch historycznych matrixów - elales i kretes i to jednego dnia :) 21 grudnia był dniem cudów :)",
    'GhostDiamond' => "Ten rok to dla mnie przede wszystkim inspirujące spotkania z ludźmi pełnymi pasji czyli ewenty, cito, Mikołajki i inne, ale jego najpiękniejszym zwieńczeniem stał się grudniowy debiut mojego kesza\n\n\"Ulepimy dziś... kesza?\" (GCBFYHJ).\n\n To projekt szczególny, bo łączący urodzinową dedykację dla wyjątkowej osoby dla mnie.\n Oraz z misją wywoływania uśmiechu na twarzach dzieci niezależnie od sytuacji, w jakiej się znajdują.",
    'Zuśka_Kluśka' => 'Zalogowałem wszystkie zaległe kesze:)',
    'Ruda_Mała_Mi' => 'Skónczyłam Matrixa, założyłam 2 kesze podczas pobytu w szpitalu w Zakopanem (STF został przyłapany na gorącym uczynku, ale i tak nie znaleźli finału ;)',
    'CopernicusHigh' => 'Spektakularnych osiągnięć brak, ale za to po latach geocacherskiego marazmu wróciłam do zakładania keszy. No i w czasie wakacji dotarłam do pięknego miejsca, gdzie nie było ani pół kesza i zaraziłam geocachingiem lokalnego przewodnika. Efekt: pierwsze kesze czekające tam na publikację i zaktualizowana strona na Wikipedii dotycząca geocachingu w krajach Luzofonii',
    'jodelka' => 'W tym roku bardziej poczułam, że moje podróże, małe i duże, dzięki geocachingowi są ciekawsze.',
    'karibud' => 'Ten rok akurat nie był keszersko wybitny w moim wykonaniu jednak z całą pewnością chwile, które zostaną mi w pamięci to 2000 kesz na giga w Pradze oraz niespodziewane spotkanie z Wami w Rzymie XD',
    'kretes' => 'Moje najszczęśliwsze wspomnienie z 2025 roku to niespodziewane ukończenie matrixa w bardzo ciekawym miejscu i w przemiłym towarzystwie!',
    'elales' => 'Miałam plan, żeby ze smutkiem wysłać wiadomość, że to był kolejny rok bez matrixa. Jednak okazało się, że geoprzyjaciele zrobili mi nie lada niespodziankę i z wielkim wzruszeniem przyznaję, że to jest rok, w którym ukończyłam pierwszego matrixa.',
    'zuzix_854' => 'Cały 2025 owocował w mnóstwo super wydarzeń i wspomnień. Z tego roku najbardziej wynoszę ze sobą ogrom wspaniałych skrytek, wspolne nagrywki do GIFFa, oraz oczywiście pamiętną wyprawę po 16 typów :)',
    'ptaki_polski_13' => 'Znalazłem 1000 keszy i udało mi się zdobyć 2 FTFy na Chorwacji i jest to mój piąty rok na geocachingu.',
    'Prezes201' => 'Początkowo jako cel na rok 2025 ustaliłem sobie, żeby ten rok był po prostu lepszy keszowo od poprzedniego, po kilku miesiącach szło na tyle dobrze, że wbicie 10 tysięcy znalezień, również stało się realnym celem, który spełniłem 19 grudnia w Rzymie. W tym roku wpadło około 4,5 tys. znalezień z czego 2,5 tys. nie licząc labów. Udało mi się również skończyć matrixa na lajciku z Emsonem.',
    'daksya' => '536 powiatów ze znalezionym keszem w 2025 roku - 19 miejsce w Europie i 25 na Świecie w tej statystyce w tym roku. Przy okazji dokończenie zazielenienia wszystkich powiatów w Polsce.',
    'Majki_Obbi' => 'W 2025 roku w moich statystykach przybyło ponad 780 znalezień i założyłem wreszcie skrytki w moim rodzinnym mieście Chrzanowie, ale to wszystko nieważne, bo najbardziej cieszy mnie tysiąc pięćset sto dziewięćset uśmiechów, żartów, wygłupów, miłych słów i dobrych wspomnień, jakie zebrałem podczas spotkań z innymi keszerami i keszerkami. Dziękuję!',
    'Piętaszek' => 'w tym roku, największym dla mnie wydarzeniem było zaproszenie mnie na event we Wrocławiu, na którym mogłem powiedzieć kilka słów na temat mojej książki, którą napisałem kilka lat temu ☺️ Bardzo fajnie, że ktoś o tym pamiętał i wyciągnął książkę i przy okazji mnie z otchłani historii 😁 Z tego co kojarzę, była to pierwsza taka publikacja w Polsce, poświęcona w 100% Geocachingowi.',
    'GoGacekGC' => 'Gacek nie zaliczy tego roku do udanych. Definitywne zakończenie działalności Stowarzyszenia Geocaching Małopolska rzuciło cień na radości z keszowania w tym roku. A były to wszelkie spotkania, w szczególności na Szczytach Korony Krakowa, jeden skromny FTF, znalezienie najstarszej skrytki Małopolski i wyjątkowej przygody przy "Festiwalu Nietoperzy" oraz poznanie (także keszowych) ciekawostek Sewilli i Norwegii. Z nadzieją lepszego roku 2026...',
    'chrupek_4' => 'W tym roku udało mi się zwiedzić wzdłuż i wszerz całą Skandynawię, a wisienką na torcie było znalezienie najstarszego kesza w Danii "Kippers in the Jungle (Denmark\'s first)" GC6A',
    'Krecik40' => 'W tym roku odwiedziłem 1 "Nowy Kraj" - Rumunię w którym można było zobaczyć kontrasty architektoniczne oraz zapełniłem kalendarz z wielkością skrytki "inna"',
    'piechurek7' => 'Najlepiej wspominam wieloosobowe wyprawy keszerów. Niezależnie od organizatora oraz destynacji, zawsze panowała świetna atmosfera, dobra współpraca, a keszowanie dawało wiele radości i dostarczało niesamowitych przygód.',
    'Sandra_Piotr_BUKOWNO' => "Oprócz letniej wyprawy do Rzymu, podczas której zalogowaliśmy niezliczoną ilość Earthcache'y i Virtuali, 2025 przebiegł głownie w kierunku statystyk. Jest tego bardzo dużo, ale dumni jesteśmy z tej jednej:\nW 2025 roku udało nam się zdobyć prawie 200 FTF'ów - kilkadziesiąt więcej niż Kranfagel ;)",
    'PL_MASA' => "2025… sukcesy drzewne, stworzenie grupy keszerskiej w pracy, Giga w Pradze i pierwszy webcam, pierwsze wędkowanie, keszowanie bardzo daleko od domu, geo-przyjaciele z krakowskiej społeczności, mój pierwszy zorganizowany event i… 1600 znalezień",
    'AsereczeKK' => "Za nami pierwszy pełny rok keszowania. Rok temu gdy zaczynaliśmy, na podsumowaniu były 62 kesze teraz jest ponad 500, więc idzie do przodu ;) zgarnęliśmy kilka szczególnych dla nas keszy w Kapadocji w Turcji Które mają ponad 20 lat, dziękujemy znajomym keszerom za ten rok. To był super czas!",
    'M&O&P' => "W tym roku udało nam się ponownie poszerzyć zasięg naszego keszowania, tym razem zdobyliśmy najdalej jak dotąd wysunięty na południe kesz, na Sri Lance, w Tangalle GC5RGTK . Kraj ten nas zachwycił: piękne starożytne stupy, przyroda i dzikie słonie... Naliczyliśmy ich setkę podczas jednodniowego safari 😍.",
    'soratte' => "Keszowanie krajoznawcze w dobrym towarzystwie, poza ubitymi szlakami. Mołdawia i Azerbejdżan, polecam.",
    'falcon1984pl' => "- dalsze czerpanie przyjemności i satysfakcji z geocachingu\n - skupiam się głównie na keszowaniu po Krakowie i najbliższej okolicy, atakowaniu FTF jesli jest możliwość ;)\n - wyjazd kilkudniowy na Geocaching Party 2025 (Warszawa) gdzie zrobilismy z synem ponad 200 pkt z labami\n - oprocz tego troche keszowania na Pomorzu podczas majówki i wakacji",
    'hedonic' => "Spontaniczny wypad na Giga do Pragi, zorganizowanie czterech eventów w czterech krajach (Indie, ZEA, Tajlandia i CCE w Kambodży z okazji mojego 15lecia dołączenia do grona keszerów, z tej okazji konsumowaliśmy suszone owady i owoce lotosu).",
    'bezsenna' => "Z tego roku najlepiej wspominam event, na którym był sam papież Leon XIV :) W tłumie ludzi nie znalazłam keszerów z eventu, ale za to gość honorowy dwukrotnie przejechał swoim papamobile po placu św. Piotra.",
    'najlepsi<3' => " myślę że 2025 rok był rokim, w którym udało się wiele. Było wiele wyjazdów, w końcu padł matrix, później drugi i trzeci(!). Nie wykluczone, że padnie jeszcze czwarty. Udało mi się odwiedzić 5 krajów, zrobić ciągłość (trwa nadal!), może uda się dobić do 2000 znalezień.\n Wiele się działo, wiele świetnych keszy i eventów, wiele wspomnień i sytuacji, które na pewno zostaną ze mną na dłużej:)",
    'Pogliś' => "zastanawialiśmy się co najlepiej wybrać na ten nasz slajd i chyba ze stricte keszowych osiągnięć to pierwsze Giga, pierwsze BlockParty i pierwszy GPS Maze (czy jak mu tam). A poza tym no to najważniejsze w tym roku było powiększenie się składu Poglisia :)",
    'xMt' => "wyjazd na kilka dni na Słowację, żeby załapać się na event \"2025 CCE : MISSION (IM)POSSIBLE\" (GCAXHF7), pierwsze moje wydarzenie w tym pięknym kraju.",
    'pocztapp' => "W 2025 roku udało mi się wcielić w życie projekt Wielicki tour z 29 multakami wokół Wieliczki, który pokazuje różnorodność tego regionu i przemianę obyczajową na podkrakowskiej wsi.",
    'hejgosia' => "Przeżyłam kolejny rok jako żona keszra! Przy tej okazji poznałam wiele ciekawych i mniej ciekawych miejsc :)",
    'MaryKisiek' => "Narysowałam logo krakowskiej społeczności keszerskiej wg pomysłu pocztappa. Cieszę się, że to właśnie ten projekt zyskał Wasze uznanie i będziecie go dumnie nosić na Waszych strojach.",
    'marcin3243' => "znalazłem partnerkę życiową, która jest keszerką :)",
    'dadadsfasd' => "Dębica on tour, bardziej rodzinną częścią czyli belka27, buryas, qauuasznik, FrFr77 i dadadsfasd, USA wrzesień/październik 2025. przejechaliśmy 10000km od Chicago do Sedony i z powrotem, odwiedzając łącznie 13 stanów. wpadło trochę starych keszy z 2000 roku, w tym aż 3 z maja, przede wszystkim MINGO (GC30), czyli najstarszy aktywny kesz, a siódmy w ogóle, który jest nawet zaznaczony na google maps i ma swoją tablicę informacyjną, oraz jedyny na świecie kesz z atrybutem kaktus, znajdujący się w lesie w stanie Wisconsin gdzie nawet nie ma kaktusów😁. oprócz tego przeżyliśmy masę przygód, tych keszerskich i nie tylko.",
    'Kosoff' => "Udało mi się znaleźć kesza na wysokości ponad 5000 metrów\nUdało mi się zamknąć liste znalezień keszy w każdym z krajów UE",
    'Svarträv' => "Rok 2025 upłynął pod niemal wyłącznym znakiem nietypowych eventów - z okazji 25-lecia GC udostępniono możliwość zmiany Mega- i Gigaeventów w Block Party oraz rozdano eventy CCE i to właśnie ich szlakiem podążałem przez ostatnie 12 miesięcy.\n W tym roku odwiedziłem:\n -Block Party w 7 krajach co dało miejsce 1. w Małopolsce i ex aequo 1. w Polsce (chyba, że Wiesia.K była w Holandii i jeszcze nie zalogowała tego wyjazdu)\n -GPS Maze w 3 krajach co dało miejsce 1. w Małopolsce i 1. w Polsce\n -Mega Eventy w 3 krajach co dało miejsce ex aequo 2. w Małopolsce i ex aequo 2./3. (zależy jak liczyć) w Polsce (Gratulacje dla Najlepsi<3)\n -CCE w 7 krajach co dało miejsce 1. w Małopolsce i ex aequo 2. w Polsce\n -CITO w 4 krajach co dało miejsce ex aequo 1. w Małopolsce i ex aequo 3. w Polsce\n Co ciekawe tylko pierwszy z tych podpunktów był celowy - resztę uświadomiłem sobie dopiero teraz patrząc w statystyki. Co więcej na wszystkie te osiągnięcia wykorzystałem 1 (słownie: JEDEN) dzień urlopu, całą resztę zamykając w wyjazdach weekendowych.",
    'Fishu' => "Z 2025 najlepiej będę wspominał wszystkie Lajciki Z .. i spotkania, w tym niezapomniany EKA i pobudki o 1, 2 ,3 - no i 4-tej nad ranem :)\n Z osiągnieć warte odnotowania białą kredą na kominie:\n 1-wszy nasz Jasmer - zamknięty wraz z m2mPL na GC4D Match Stash 7 czerwca 2025 , w miłym towarzystwie Piotr i Agnieszka Daksya oraz Michał Barucci!\n 13 najstarszych keszy w 13 krajach w 2025 (w sumie 21 najstarszych)\n 10 000 keszy na liczniku (niestety z labami)\n 15 Krajów w jeden dzień, oj co to była za wyry..prawa, była nawet kawa :)\n 15 Typów w jeden dzień , tak wiem macie więcej o jeden :P\n O liczbie odwiedzonych krajów nie będę wspominał, bo w grudniu zostaliśmy odsadzeni przez jakiegoś Żurawia :P\n Jeśli 2024 był niezapomniany, to co tu powiedzieć o 2025 ?",
    '1990ds' => "W końcu się przełamałem i zorganizowałem event! Na razie na wyjeździe, ale i na Kraków przyjdzie czas.",
    'Krzosz' => "Był to słaby keszersko rok. Uśredniając niewiele ponad 100 znalezień na miesiąc.",
    'kluczdoskarbu' => "Za moje największe w tym roku osiągnięcie uważam to, że udało mi się ukończyć pierwszego, drugiego a nawet trzeciego matrixa!",
    'dadoskawina' => "Świadomym osiągnięciem, które mnie bardzo ucieszyło jest skompletowanie powiatów w Czechach. (można dodać, że jako pierwszy, i jak dotąd - jedyny - gracz z Małopolski :) )\n A jako pierwszy w Polsce osiągnąłem 111 CITO, co pozwoliło mi zdobyć FTF-a na challengu we Wrocławiu :)\n Statystyki powinienem mieć dostępne, aczkolwiek nie mam ciekawych, więc nawet nie musisz zaglądać.",
    'barucci' => "Moim największym geocachingowym osiągnięciem w 2025 był krakowski film GIFFowy, w którym wystąpił każdy, dosłownie każdy, kto chciał się zaangażować - drugorzędne, że sam film trafił do finałowej rolki Geocaching International Film Festival ;)",
    'aforyzm' => "To co mi się udało w tym roku to w końcu przekroczenie magicznego progu 1000 znalezień. Co prawda liczę z LABkami, bo bez nich jeszcze trochę mi brakuje, ale i tak bardzo cieszę się z tego mojego małego sukcesu.",
    'Milk_Bandit' => "Założenie geoarta jednorożca.\nZnalezienie półtora tysiąca keszy.\nZnalezienie 15 typów w niecałe 4 godziny.\nPrzekroczyliśmy 100 założonych keszy.",
    'POKEMISTRZ' => "Rok 2025... Geocachingowo przełomowy! Zrobienie ciągłości, zamknięcie pierwszego matrixa, dwa nowe kraje, kesz z 2000 roku, 2x block party, a także pierwszy MoM w terenie, a przede wszystkim mnóstwo świetnych wspomnień podczas eventów czy wyjazdów! To był świetny rok!",
    'UnicornCacherPL' => "Zorganizowanie pierwszego eventu o jednorożcach.\nZałożenie pierwszego kesza w Artystycznym Ogrodzie Krakowian.\nZnalezienie tysięcznego kesza.",
    'TomekS1976' => "Największym sukcesem TomkaS1976 był fakt, że na organizowany przez niego event (GCB5386) pierwszy raz przyszedł ktoś poza nim samym.",
    'Emson_' => "Osiągnięciem keszerskim, które uważam za najważniejsze w 2025 roku, jest najwięcej opublikowanych eventów w Polsce.",
    'pigeox69' => "Najbardziej, jak zawsze, cieszą nas zdobyte FTFy. W tym roku udało nam się zalogować ich najwięcej spośród wszystkich polskich keszerów.",
    'holdasy' => "To blył Mega rok. Ba, to był nawet GIGA rok!\n Wpadłem w Matriksa po 15 latach a rodzina zaczyna coś mówić o nałogu...\n I pamiętajcie - po pierwsze: Laby to ZUO, po drugie: na pohybel smutasom.",
    'Team_SirWonski' => "Bawimy się dalej i poznajemy nowych keszerów. W tym roku zorganizowaliśmy 1 swój event USTRZEL SOBIE ŚNIADANIE i puściliśmy małą serię ODLOT\nDo zabawy włączył również  Hiszpania 145, który  sam już zakłada swoje skrzynki i ambitnie szuka nowych keszy.",
];

$memoriesCounter = 0;
$memorySliceSize = ceil(count($memories) / 11);
$memorySlices = array_chunk($memories, $memorySliceSize, true);

$slides = [
    [
        ['type' => SlideType::MONTH, 'month' => '01', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATKXD', 'title' => 'Nowy rok, nowe sięganie do gwiazd.', 'owner' => 'soratte', 'date' => '1 stycznia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATNV3', 'title' => 'Krakowskie podsumowanie 2024', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '6 stycznia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB1GGP', 'title' => 'KSzK', 'owner' => 'Quard32', 'owner2' => 'udar2', 'date' => 'styczeń - listopad',
            'points' => [
                'Zdobyte szczyty – Wzgórze Krzemionki, Górka Pychowicka, Góra Solnik, Wzgórze Kaim, Kopiec Krakusa, Guminek, Sikornik, Srebrna Góra, Ostra Góra, Wzgórze Rajsko, Pustelnik,',
                '11 eventów',
                '222 attendy',
                '60 keszerów (nicków)',
                'Najliczniej odwiedzony event GCB52EF – KSzK #6 - Wzgórze Kaim – 27 attendów – 29 wpisów (nicków) w logbooku',
            ]],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB1VPR', 'title' => 'Chodź, opowiem Ci o Polsce', 'owner' => 'Emson_', 'others' => true, 'date' => 'październik 24 - kwiecień 25',
            'points' => [
                'październik 24 - kwiecień 25',
                '9 eventów, 4 organizatorów',
                '165 attended, 55 nicków keszerskich',
                'najwyższa frekwencja Qinka, Justyna94, Dominisia_krk (8 z 9)',
                'Tarnów, Dębica, Ciężkowice, Opole, Bochnia, Zalipie, Pacanów, Mielec, Radłów',
            ]],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAXHV2', 'title' => '🥂🎂🍾Trzecie GeoUrodziny🍾🎂🥂', 'owner' => 'udar2', 'owner2' => 'Kasia_2014', 'owner3' => 'Quard32', 'date' => '22 stycznia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAZZC4', 'title' => 'Kto rano wstaje...', 'owner' => 'Kosoff', 'date' => '30 stycznia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB23NB', 'title' => 'GeoPubQuiz 🤔❓', 'owner' => 'Emson_', 'date' => '30 stycznia'],
    ],
    [
        ['type' => SlideType::TITLE, 'title' => 'Eventy', 'bg' => '2025/images/bgs/events.gif'],
        ['type' => SlideType::NUMBERS, 'title' => 'Eventy 2025',
            'source' => 'https://project-gc.com/Statistics/GeocachesPerArea?filter_crc_country=Poland&filter_crc_region=Ma%C5%82opolskie&filter_ts_type%5B%5D=Event+Cache&filter_hd_fromDate=2025-01-24&filter_hd_toDate=2025-12-31&filter_dae_archived=on&filter_dae_pastEvents=on&submit=Filter',
            'numbers' => [
                ['label' => 'Liczba eventów w Krakowie', 'number' => 141, 'additional' => '(147 w 2024 r.)'],
                ['label' => 'Liczba eventów w Małopolsce', 'number' => 172, 'additional' => '(201 w 2024 r.)'],
            ]],
        ['type' => SlideType::NUMBERS, 'title' => 'CCE 2025',
            'source' => 'https://project-gc.com/Statistics/GeocachesPerArea?filter_crc_country=Poland&filter_crc_region=Ma%C5%82opolskie&filter_ts_type%5B%5D=Lost+and+Found+Event+Cache&filter_hd_fromDate=2025-01-24&filter_hd_toDate=2025-12-31&filter_dae_archived=on&filter_dae_pastEvents=on&submit=Filter',
            'numbers' => [
                ['label' => 'Liczba CCE w Krakowie', 'number' => 20],
                ['label' => 'Liczba CCE w Małopolsce', 'number' => 28],
            ]],
        ['type' => SlideType::NUMBERS, 'title' => 'CITO 2025',
            'source' => 'https://project-gc.com/Statistics/GeocachesPerArea?filter_crc_country=Poland&filter_crc_region=Ma%C5%82opolskie&filter_ts_type%5B%5D=Cache+In+Trash+Out+Event&filter_hd_fromDate=2025-01-24&filter_hd_toDate=2025-12-31&filter_dae_archived=on&filter_dae_pastEvents=on&submit=Filter',
            'numbers' => [
                ['label' => 'Liczba CITO w Krakowie', 'number' => 10],
                ['label' => 'Liczba CITO w Małopolsce', 'number' => 14, 'additional' => '(12 w 2024 r.)'],
            ]],
        ['type' => SlideType::BAR_CHART, 'stats' => 'events_attends.json', 'title' => 'Attendy', 'source' => 'https://project-gc.com/Statistics/TopFinders?filter_pr_profileName=kranfagel&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=&filter_ts_type%5B%5D=Cache+In+Trash+Out+Event&filter_ts_type%5B%5D=Event+Cache&filter_ts_type%5B%5D=Groundspeak+Block+Party&filter_ts_type%5B%5D=Lost+and+Found+Event+Cache&filter_ts_type%5B%5D=Mega-Event+Cache&filter_ld_fromDate=2025-01-01&filter_ld_toDate=2025-12-31&submit=Filter'],
        ['type' => SlideType::BAR_CHART, 'stats' => 'events_attends_krakow.json', 'title' => 'Attendy (Kraków)', 'source' => 'https://project-gc.com/Statistics/TopFinders?filter_pr_profileName=kranfagel&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=Poland&filter_crc_region=Ma%C5%82opolskie&filter_crc_county=Krak%C3%B3w&filter_ts_type%5B%5D=Cache+In+Trash+Out+Event&filter_ts_type%5B%5D=Event+Cache&filter_ts_type%5B%5D=Groundspeak+Block+Party&filter_ts_type%5B%5D=Lost+and+Found+Event+Cache&filter_ts_type%5B%5D=Mega-Event+Cache&filter_ld_fromDate=2025-01-01&filter_ld_toDate=2025-12-31&submit=Filter'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '02', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2M0V', 'title' => 'Czas na pizze', 'owner' => 'Zuśka_Kluśka', 'date' => '7 lutego'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAYNWM', 'title' => 'Pele Mele Quiz - Geocachingowe Złote Myśli Finał', 'owner' => 'barucci', 'date' => '13 lutego'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2TEE', 'title' => 'Przegląd gier terenowych #1 🔍🗺️', 'owner' => 'Emson_', 'date' => '19 lutego'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2TE8', 'title' => 'Czy zjesz ze mną pączusia? 🍩', 'owner' => 'Emson_', 'date' => '27 lutego'],
    ],
    [
        ['type' => SlideType::TITLE, 'title' => 'Statystyki założeń', 'bg' => '2025/images/bgs/hide.gif'],
        ['type' => SlideType::BAR_CHART, 'stats' => 'hidden_events.json', 'title' => 'Założone eventy', 'source' => 'https://project-gc.com/Statistics/TopHidden?filter_pr_profileName=&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=&filter_ts_type%5B%5D=Cache+In+Trash+Out+Event&filter_ts_type%5B%5D=Event+Cache&filter_ts_type%5B%5D=Lost+and+Found+Event+Cache&filter_hd_fromDate=2025-01-01&filter_hd_toDate=2025-12-31&submit=Filter'],
        ['type' => SlideType::BAR_CHART, 'stats' => 'hidden_events_krakow.json', 'title' => 'Założone eventy (Kraków)', 'source' => 'https://project-gc.com/Statistics/TopHidden?filter_pr_profileName=&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=Poland&filter_crc_region=Ma%C5%82opolskie&filter_crc_county=Krak%C3%B3w&filter_ts_type%5B%5D=Cache+In+Trash+Out+Event&filter_ts_type%5B%5D=Event+Cache&filter_ts_type%5B%5D=Lost+and+Found+Event+Cache&filter_hd_fromDate=2025-01-01&filter_hd_toDate=2025-12-31&submit=Filter'],
        ['type' => SlideType::BAR_CHART, 'secret' => true, 'stats' => 'hidden.json', 'title' => 'Założone kesze', 'source' => 'https://project-gc.com/Statistics/TopHidden?filter_pr_profileName=&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=&filter_ts_type%5B%5D=Earthcache&filter_ts_type%5B%5D=Letterbox+Hybrid&filter_ts_type%5B%5D=Multi-cache&filter_ts_type%5B%5D=Traditional+Cache&filter_ts_type%5B%5D=Unknown+Cache&filter_ts_type%5B%5D=Virtual+Cache&filter_ts_type%5B%5D=Wherigo+Cache&filter_hd_fromDate=2025-01-01&filter_hd_toDate=2025-12-31&submit=Filter'],
        ['type' => SlideType::BAR_CHART, 'stats' => 'hidden_krakow.json', 'title' => 'Założone kesze (Kraków)', 'source' => 'https://project-gc.com/Statistics/TopHidden?filter_pr_profileName=&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=Poland&filter_crc_region=Ma%C5%82opolskie&filter_crc_county=Krak%C3%B3w&filter_ts_type%5B%5D=Earthcache&filter_ts_type%5B%5D=Letterbox+Hybrid&filter_ts_type%5B%5D=Multi-cache&filter_ts_type%5B%5D=Traditional+Cache&filter_ts_type%5B%5D=Unknown+Cache&filter_ts_type%5B%5D=Virtual+Cache&filter_ts_type%5B%5D=Wherigo+Cache&filter_hd_fromDate=2025-01-01&filter_hd_toDate=2025-12-31&submit=Filter'],
        ['type' => SlideType::BAR_CHART, 'top' => 6, 'secret' => true, 'stats' => 'hidden_multi.json', 'title' => 'Założone kesze (multi)', 'source' => 'https://project-gc.com/Statistics/TopHidden?https://project-gc.com/Statistics/TopHidden?filter_pr_profileName=&filter_prr_country=Poland&filter_prr_region=Ma%C5%82opolskie&filter_crc_country=&filter_ts_type%5B%5D=Multi-cache&filter_hd_fromDate=2025-01-01&filter_hd_toDate=2025-12-31&submit=Filter'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '03', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB358W', 'title' => 'Wizytówki i certyfikaty 4', 'owner' => 'Emson_', 'date' => '1 marca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB0RE0', 'title' => 'Muuuuszę tu posprzątać', 'owner' => 'kranfagel', 'date' => '2 marca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB3QGX', 'title' => '🎲 Planszówkowy event 🎲', 'owner' => 'Qinka', 'date' => '12 marca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAW13Y', 'title' => 'Rubik\'s CCE', 'owner' => 'Milk_Bandit', 'date' => '19 marca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB40E7', 'title' => 'CITO - Czysta Wisłoka #3', 'owner' => 'Peter_PL', 'date' => '25 marca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB1EEA', 'title' => 'GeoPloty x GeoDebaty - Co z Geocaching Małopolska?', 'owner' => 'Dominisia_krk', 'date' => '26 marca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB49CM', 'title' => '🌖 Spotkanie wielbicieli sera i nocnego nieba 🌒', 'owner' => 'Dominisia_krk', 'date' => '27 marca'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '04', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAYQA4', 'title' => 'Święto Tarnowskiej Turystyki 2025', 'owner' => 'Emson_', 'date' => '5 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB3ZYT', 'title' => 'Znakujemy szlak w Szczepanowicach 🖌️🟢', 'owner' => 'Emson_', 'date' => '5 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2J2G', 'title' => '🦄✨ Unicorn Day ✨🦄', 'owner' => 'UnicornCacherPL', 'date' => '9 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB4YTZ', 'title' => 'PISANKA', 'owner' => 'juleczkap23', 'date' => '12 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB3001', 'title' => 'GeoSlajdowisko 12 - Maroko', 'owner' => 'kranfagel', 'owner2' => 'kretes', 'date' => '14 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2RN5', 'title' => 'Kto rano wstaje, temu wschód słońca w piżamie!', 'owner' => 'Dominisia_krk', 'owner2' => 'mugol_02', 'date' => '16 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB2RN6', 'title' => 'W Rio Leżaneiro zimno, weź piżamę i na zachód wio!', 'owner' => 'Dominisia_krk', 'owner2' => 'mugol_02', 'date' => '16 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB56QV', 'title' => 'GeoFilmowanie - cz. 1', 'owner' => 'barucci', 'date' => '16 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB5CYR', 'title' => 'Ło matko, gdzie was znowu poniosło?', 'owner' => 'Fishu', 'date' => '22 kwietnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB56XX', 'title' => 'CITO w czwartek', 'owner' => 'soratte', 'date' => '24 kwietnia'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '05', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAGGGG', 'title' => '25 Years of Geocaching – Prague 2025', 'owner' => 'PragueGigaTeam', 'date' => '3 maja'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB57AB', 'title' => 'Koniec', 'owner' => 'Emson_', 'date' => '6 maja'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB7A95', 'title' => 'Ło matko, gdzie nas znowu poniosło?', 'owner' => 'Dominisia_krk', 'date' => '28 maja'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '06', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB6XG3', 'title' => 'GeoSlajdowisko 13 - Islandia i ziemia Krośnieńska', 'owner' => 'yuve', 'owner2' => 'Emson_', 'date' => '4 czerwca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB7ZKW', 'title' => 'GeoGraTerenowa 2.0 - Błonia', 'owner' => 'Chamaneax_PL', 'date' => '12 czerwca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB816D', 'title' => 'Posprzątajmy Radłów!', 'owner' => 'Kosoff', 'date' => '14 czerwca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB82G7', 'title' => 'Trening Keszera', 'owner' => 'Emson_', 'others' => true, 'date' => 'czerwiec - grudzień',
            'points' => [
                'Rozpoczęcie sezonu, Ćwiczenia na drążku, Pływanie, Joga 2, Bieganie + sztafeta, Kolarstwo, Wspinaczka i dostęp linowy, Disc golf, Kręgle 2, Ping-pong 2, Rugby, TRInO, Twister 2, Skok w dal, Wspinanie po ściance, TempO, Równoważnia, Siłownia zewnętrzna, Morsowanie listopad, Zakończenie sezonu',
                '20 eventów',
                '4 organizatorów',
                '72 uczestników (nicków keszerskich)',
                '285 attended',
                'Wygrał Najlepsi<3',
            ]],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '07', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB94K4', 'title' => 'GeoSlajdowisko 14 - Barcelona', 'owner' => 'Emson_', 'date' => '10 lipca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB7778', 'title' => 'Celebrating 20 years with Team PodCacher (PIKNIK)', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '14 lipca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB9FZ0', 'title' => 'Środek Wakacji', 'owner' => 'soratte', 'date' => '22 lipca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB9N3M', 'title' => 'DIY: zróbmy sobie wakacyjne bransoletki', 'owner' => 'Qinka', 'date' => '23 lipca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB9999', 'title' => 'GeoSlajdowisko 15 - Austria, Singapur, Malezja, Indonezja', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '24 lipca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB1Y11', 'title' => 'Log & Roll 2025', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'owner3' => 'marcin3243', 'date' => '26 lipca'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAW0G1', 'title' => 'Piknik urodzinowy - jak te 10 lat zleciało!', 'owner' => 'Dominisia_krk', 'date' => '31 lipca'],

    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '08', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAYP9A', 'title' => 'Morskie opowieści - CCE', 'owner' => 'xMt', 'date' => '2 sierpnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB9C8F', 'title' => '𝕊𝕫ℤ𝕫𝔸𝕝𝕠𝕆𝕠𝕟𝔼 𝕀𝕆 𝕝𝕒𝕥 😉', 'owner' => 'Einsztein27', 'date' => '3 sierpnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATN5B', 'title' => 'Juraidy 2025, czyli Idzie niebo ciemną nocą CCE', 'owner' => 'CopernicusHigh', 'date' => '9 sierpnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBA1K7', 'title' => 'Jurajskie Sprzątanko', 'owner' => 'Milk_Bandit', 'date' => '20 sierpnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBB12W', 'title' => 'IV GeoDebaty', 'owner' => 'barucci', 'date' => '21 sierpnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAWWFM', 'title' => 'WWFM XXII - na galowo', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '23 sierpnia'],
        ['type' => SlideType::YOUTUBE, 'title' => 'WWFM XXII - na galowo', 'id' => 'KxLkrHMWmIo'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBBEGM', 'title' => 'Koniec Wakacji', 'owner' => 'soratte', 'date' => '29 sierpnia'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '09', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB0Y8D', 'title' => 'Buła (krowa) ser i bule ;P', 'owner' => 'm2mPL', 'date' => '20 września'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBCTZ3', 'title' => '2 w 1: Pocztówkowe CITO w kamieniołomie!', 'owner' => 'barucci', 'date' => '28 września'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATMMZ', 'title' => 'Ognisko z okazji', 'owner' => 'dadoskawina', 'date' => '30 września'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '10', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBCE9Z', 'title' => 'Postcard Day w Krakowie', 'owner' => 'm2mPL', 'date' => '1 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB3K0N', 'title' => 'Czy my w końcu zjemy tę kiełbasę?', 'owner' => 'kranfagel', 'date' => '9 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBA1HK', 'title' => '#Skrajności Krakowa', 'owner' => 'najlepsi<3', 'date' => 'październik - listopad'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB1Y6H', 'title' => 'Płonie ognisko i szumią knieje', 'owner' => 'Quard32', 'owner2' => 'udar2', 'date' => '13 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBARWA', 'title' => 'Wybieramy naszą barwę - logo Geocaching Kraków', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '15 i 29 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB0YRA', 'title' => '2025 CCE: Od kiedy ziemniaki to dobre wieści?', 'owner' => 'leneia', 'date' => '18 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAYQAR', 'title' => '✨ Magiczne Geourodziny – 12 lat przygód ✨', 'owner' => 'Qinka', 'date' => '21 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBDT89', 'title' => 'CITO - 🍂 Jesień 2025 🍂', 'owner' => 'Peter_PL', 'date' => '25 października'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATKNH', 'title' => '25 lat geoachingu - ponownie na drezynach', 'owner' => 'nemrodek', 'date' => '26 października'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '11', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBC1T1', 'title' => 'Kamieniołom Mydlniki v4', 'owner' => 'kranfagel', 'owner2' => 'Dominisia_krk', 'owner3' => 'marcin3243', 'date' => '11 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATNGB', 'title' => 'GIFF 2025 Kraków - CCE', 'owner' => 'daksya', 'owner2' => 'kranfagel', 'date' => '12 listopada'],
        ['type' => SlideType::YOUTUBE, 'title' => 'GIFF 2025 Kraków - CCE', 'id' => 'OczuNPRvqPU'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBAZAT', 'title' => 'Słoiki', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '14 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATNN8', 'title' => 'GeoPubQuiz 2 🤔❓', 'owner' => 'Emson_', 'date' => '21 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBDWWX', 'title' => 'Nocne polowanie na wiązkę lasera z satelity ICESat', 'owner' => 'zucharek', 'date' => '21 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAW085', 'title' => 'GEOrientuj się pod Drabożem', 'owner' => 'seba54', 'date' => '23 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBF6HN', 'title' => 'CITO we wtorek', 'owner' => 'soratte', 'date' => '25 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATNMJ', 'title' => '🎊 CCE - Świetujemy i wspominamy 🎉', 'owner' => 'Peter_PL', 'date' => '25 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAVZQ5', 'title' => '15 lat minęło - 2025 Community Celebration Event', 'owner' => 'Fishu', 'owner2' => 'm2mPL', 'date' => '26 listopada'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBECR0', 'title' => 'Międzynarodowy Dzień Ciasta 🥧🎂🍰', 'owner' => 'Emson_', 'date' => '27 listopada'],
    ],
    [['type' => SlideType::MEMORIES]],
    [
        ['type' => SlideType::MONTH, 'month' => '12', 'subtitle' => 'urodzinki, debaty i erfy'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBFCB7', 'title' => 'Majki kończy 10 (geo)latek', 'owner' => 'Majki_Obbi', 'date' => '1 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBFEEX', 'title' => 'EKA', 'owner' => 'Dominisia_krk', 'others' => true, 'date' => 'grudzień',
            'points' => [
                [
                    '23 eventy tradycyjne i 2 CITO towarzyszące',
                    'Indywidualnych logów w serii EKA pojawiło się 344 = średnio przypada 15 uczestników na event + osoby towarzyszące',
                    'Najmniej liczny okazał się EKA 9 przy ulicy Świerkowej - przyszło 8 osób',
                    'Najlepszą frekwencją cieszyły się aż trzy eventy: EKA 16 przy ulicy Rybnej, EKA 20 przy ulicy Świętej Rodziny i EKA 22 przy placu Mariackim. Na każdym pojawiło się 21+ osób, a na jednym nasz lokalny recenzent. :)',
                    'Aż dwie osoby uczestniczyły we wszystkich spotkaniach. Tego wyczynu dokonali m2mPL i emode 🎉',
                ],
                [
                    'Po evencie i CITO przy przy Rybnej przytrafiło się złapać psiego zbiega w centrum, choć nie obyło się w tej misji bez przeszkód. Gabi została odwieziona do schroniska i niedługo wróciła do swoich właścicieli, więc mamy szczęśliwe zakończenie',
                    'Kontynuując psi wątek, na trzech eventach pojawiła się możliwość poznania młodszego brata Psikusa 🐶',
                    'Zostało wydrukowane 40 kalendarzy i tyle też się rozeszło. Naklejek w przybliżeniu zostało wydrukowane 450 :)',
                    'Za malunki w logbooku  głównym odpowiedzialne były 3 osoby: m2mPL, Dominisia_krk i Qinka',
                    'Nieprzekładalne na liczby było wspaniałe zaangażowanie i mobilizacja społeczności w ten projekt ❤️',
                ]
            ]],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBEZRT', 'title' => 'Dzień naftowca i gazownika 🔥', 'owner' => 'Emson_', 'date' => '3 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAXHG0', 'title' => 'Jak być żoną keszera', 'owner' => 'Iluminatornia', 'date' => '5 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCB0YRN', 'title' => '🎅🏻Mikołajki z Gwiazdką 🤩 2025 CCE', 'owner' => 'Gwiazdeczka_', 'date' => '5 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCATN3C', 'title' => 'Zróbże sobie szopkę', 'owner' => 'Pogliś', 'date' => '7 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBCHCE', 'title' => 'Mikołajki 🎅', 'owner' => 'kranfagel', 'owner2' => 'leneia', 'date' => '7 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBAGRY', 'title' => 'Ósmy grudnia, Szybki Mors 2', 'owner' => 'm2mPL', 'date' => '8 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBEQTN', 'title' => 'Świąteczne Pierniczki', 'owner' => 'm2mPL', 'date' => '13 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAW0EG', 'title' => '⛪️Ale Szopka! A.D.2025-2026✨ - Eventowa Celebracja', 'owner' => 'Piętaszek', 'date' => '14 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBFHQT', 'title' => 'Making of.. GIFF i wymiana kartek świątecznych :)', 'owner' => 'm2mPL', 'owner2' => 'barucci', 'date' => '18 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBFFM7', 'title' => 'Dzień Ryby 🐟', 'owner' => 'Emson_', 'date' => '20 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAYNV4', 'title' => 'Christmas Jigsaw - CCE', 'owner' => 'Milk_Bandit', 'date' => '23 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCBG75X', 'title' => 'A co było pod choinką?', 'owner' => 'Svarträv', 'date' => '25 grudnia'],
        ['type' => SlideType::EVENT, 'gccode' => 'GCAZWMY', 'title' => 'MORS CCE 2025', 'owner' => 'juleczkap23', 'date' => '27 grudnia'],

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
                    $coverPath = "2025/images/$folderId/cover.jpg";
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
                                <a href="https://project-gc.com/Tools/MapCompare?player_prc_profileName=Staszek1&geocache_mc_show%5B%5D=found-none&geocache_mc_show%5B%5D=found-one&geocache_mc_show%5B%5D=found-all&geocache_crc_country%5B%5D=Poland&geocache_crc_region%5B%5D=Ma%C5%82opolskie&geocache_crc_region%5B%5D=Podkarpackie&geocache_crc_region%5B%5D=%C5%9Al%C4%85skie&geocache_dae_disabled=on&geocache_dae_archived=on&geocache_dae_pastEvents=on&geocache_ts_type%5B%5D=Cache+In+Trash+Out+Event&geocache_ts_type%5B%5D=Event+Cache&geocache_ts_type%5B%5D=Lost+and+Found+Event+Cache&geocache_hd_fromDate=<?= $firstDay ?>&geocache_hd_toDate=<?= $lastDay ?>&submit=Filter"
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
                        <section <?= file_exists($coverPath) ? "data-background=\"$coverPath\"" : '' ?>
                                data-auto-animate>
                            <h1 class="dark-block r-fit-text"><?= $slide['title'] ?></h1>
                            <h2 class="dark-block">
                                <a href="https://coord.info/<?= $slide['gccode'] ?>"
                                   target="_blank"><?= $slide['gccode'] ?></a>
                                <?= $slide['date'] ?>
                                <a target="_blank"
                                   href="https://www.geocaching.com/p/?u=<?= $slide['owner'] ?>"><?= $slide['owner'] ?></a>
                                <?php if ($slide['others'] ?? false): ?> i inni <?php endif; ?>
                                <?php if ($slide['owner2'] ?? false): ?>
                                    &amp;
                                    <a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= $slide['owner2'] ?>"><?= $slide['owner2'] ?></a>
                                <?php endif; ?>
                                <?php if ($slide['owner3'] ?? false): ?>
                                    &amp;
                                    <a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= $slide['owner3'] ?>"><?= $slide['owner3'] ?></a>
                                <?php endif; ?>
                            </h2>
                        </section>
                        <?php if ($slide['points'] ?? false):
                        $points = is_array($slide['points'][0]) ? $slide['points'] : [$slide['points']];
                        foreach ($points as $pointGroup): ?>
                            <section data-auto-animate>
                                <h1 class="dark-block <?= strlen($slide['title']) > 10 ? 'r-fit-text' : '' ?>"><?= $slide['title'] ?></h1>
                                <?php if (!is_array($slide['points'][0])): ?>
                                    <h2 class="dark-block">
                                        <a href="https://coord.info/<?= $slide['gccode'] ?>"
                                           target="_blank"><?= $slide['gccode'] ?></a>
                                        <?= $slide['date'] ?>
                                        <a target="_blank"
                                           href="https://www.geocaching.com/p/?u=<?= $slide['owner'] ?>"><?= $slide['owner'] ?></a>
                                        <?php if ($slide['others'] ?? false): ?> i inni <?php endif; ?>
                                        <?php if ($slide['owner2'] ?? false): ?>
                                            &amp;
                                            <a target="_blank"
                                               href="https://www.geocaching.com/p/?u=<?= $slide['owner2'] ?>"><?= $slide['owner2'] ?></a>
                                        <?php endif; ?>

                                        <?php if ($slide['owner3'] ?? false): ?>
                                            &amp;
                                            <a target="_blank"
                                               href="https://www.geocaching.com/p/?u=<?= $slide['owner3'] ?>"><?= $slide['owner3'] ?></a>
                                        <?php endif; ?>
                                    </h2>
                                <?php endif; ?>
                                <ul>
                                    <?php foreach ($pointGroup as $point) : ?>
                                        <li><?= $point ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                        <?php endforeach; ?>
                    <?php endif; ?>
                        <?php if (count($photos) > 0): ?>
                        <section data-auto-animate class="photos">
                            <h1 class="dark-block <?= strlen($slide['title']) > 10 ? 'r-fit-text' : '' ?>"><?= $slide['title'] ?></h1>
                            <h2 class="dark-block">
                                <a href="https://coord.info/<?= $slide['gccode'] ?>"
                                   target="_blank"><?= $slide['gccode'] ?></a>
                                <?= $slide['date'] ?>
                                <a target="_blank"
                                   href="https://www.geocaching.com/p/?u=<?= $slide['owner'] ?>"><?= $slide['owner'] ?></a>
                                <?php if ($slide['others'] ?? false): ?> i inni <?php endif; ?>
                                <?php if ($slide['owner2'] ?? false): ?>
                                    &amp;
                                    <a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= $slide['owner2'] ?>"><?= $slide['owner2'] ?></a>
                                <?php endif; ?>
                                <?php if ($slide['owner3'] ?? false): ?>
                                    &amp;
                                    <a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= $slide['owner3'] ?>"><?= $slide['owner3'] ?></a>
                                <?php endif; ?>
                            </h2>
                            <div class="r-stack">
                                <?php foreach ($photos as $photo): ?>
                                    <img class="<?= $photo == $photos[0] ? '' : 'fragment' ?>"
                                         src="<?= dirname($coverPath) ?>/<?= $photo ?>" height="600"/>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    <?php elseif ($slide['type'] === SlideType::YOUTUBE): ?>
                        <section data-auto-animate>
                            <h1 class="dark-block"><?= $slide['title'] ?></h1>
                            <iframe width="1050" height="590" src="https://www.youtube.com/embed/<?= $slide['id'] ?>"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            <div>
                                <a target="_blank"
                                   href="https://www.youtube.com/watch?v=<?= $slide['id'] ?>">link</a>
                            </div>
                        </section>
                    <?php elseif ($slide['type'] === SlideType::TITLE): ?>
                        <section data-background="<?= $slide['bg'] ?>">
                            <h1 class="dark-block r-fit-text"><?= $slide['title'] ?></h1>
                        </section>
                    <?php elseif ($slide['type'] === SlideType::NUMBERS): ?>
                        <section>
                            <h1><?= $slide['title'] ?></h1>
                            <?php foreach ($slide['numbers'] as $number): ?>
                                <h3><?= $number['label'] ?></h3>
                                <p class="fragment number custom blur">
                                    <?= $number['number'] ?>
                                </p>
                                <?php if (isset($number['additional'])): ?>
                                    <p class="fragment custom blur small number"><?= $number['additional'] ?></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <div class="source">
                                <a href="<?= $slide['source'] ?>" target="_blank">źródło</a>
                            </div>
                        </section>
                    <?php elseif ($slide['type'] === SlideType::MEMORIES): ?>
                        <section>
                            <h1>Wspomnienia z 2025</h1>
                        </section>
                        <?php
                        foreach ($memorySlices[$memoriesCounter++] as $nick => $text):
                            $avatarUrl = $userAvatars[$nick] ?? 'https://geocaching.com/images/default_avatar.png';
                            $photosDir = '2025/nicks/' . $nick;
                            ?>
                            <section data-auto-animate>
                                <h2>
                                    <a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= urlencode($nick) ?>"><?= htmlspecialchars($nick) ?></a>
                                </h2>
                                <img src="<?= $avatarUrl ?>" class="avatar">
                                <blockquote class="fragment custom blur <?= strlen($text) > 300 ? 'wide' : '' ?>">
                                    <?= nl2br(preg_replace('/\b(GC[A-Z0-9]+)\b/', '<a href="https://coord.info/$1" target="_blank">$1</a>', $text)) ?>
                                </blockquote>
                            </section>
                            <?php if (file_exists($photosDir)):
                            $photos = array_values(array_diff(scandir($photosDir), ['.', '..']));
                            ?>
                            <section data-auto-animate>
                                <h2>
                                    <a target="_blank"
                                       href="https://www.geocaching.com/p/?u=<?= urlencode($nick) ?>"><?= htmlspecialchars($nick) ?></a>
                                </h2>
                                <?php foreach ($photos as $photo): ?>
                                    <img class="" src="/<?= $photosDir ?>/<?= $photo ?>"
                                         style="max-height: 700px; max-width: 700px"/>
                                <?php endforeach; ?>
                            </section>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    <?php elseif ($slide['type'] === SlideType::BAR_CHART):
                        $data = json_decode(file_get_contents(__DIR__ . '/2025/stats/' . $slide['stats']), true);
                        $data = array_slice($data['data'], 0, $slide['top'] ?? 10);
                        $nicks = array_map(fn($row) => $row['profile']['username'], $data);
                        $values = array_map(fn($row) => $row['cnt'], $data);
                        $anonymousData = ['data' => ['labels' => array_map(fn($n) => '?', $nicks), 'datasets' => [['data' => $values]]]];
                        $chartData = ['data' => ['labels' => $nicks, 'datasets' => [['data' => $values]]]];
                        ?>
                        <?php if ($slide['secret'] ?? false): ?>
                        <section data-auto-animate>
                            <h1 class="r-fit-text"><?= $slide['title'] ?></h1>
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
                    <?php endif; ?>
                        <section data-auto-animate>
                            <h1 class="<?= strlen($slide['title']) > 10 ? 'r-fit-text' : '' ?>"><?= $slide['title'] ?></h1>
                            <div class="chart">
                                <canvas data-chart="bar">
                                    <!--
                                    <?= json_encode($chartData) ?>
                                    -->
                                </canvas>
                            </div>
                            <div class="source">
                                <a href="<?= $slide['source'] ?>" target="_blank">źródło</a>
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
