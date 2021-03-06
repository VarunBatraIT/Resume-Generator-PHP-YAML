<?php require 'vendor/autoload.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$themes = array('a', 'b');
shuffle($themes);
$theme = array_pop($themes);
$theme = 'a';
$spyc = new Spyc();
$resume = $spyc->loadFile('./resume/resume.yml');
$parser = new \cebe\markdown\MarkdownExtra();
extract($resume);
$classes = $classes[rand(0, count($classes) - 1)];

function link_implode($delimiter, $array)
{
    $new_array = array();
    foreach ($array as $title => $link) {
        array_push($new_array, "<a target='_blank' href='$link'>$title</a>");
    }
    return implode($delimiter, $new_array);
}

function isAssoc($array)
{
    return ($array !== array_values($array));
}

function add_class($level, $where = 'title')
{
    global $classes;
    if (isset($classes[$level], $classes[$level][$where])) {
        return $classes[$level][$where];
    }

}

function add_links($string)
{
    global $links;
    foreach ($links as $text => $link) {
        $string = str_replace($text, "<a target='_blank' href='$link'>$text</a>", $string);
    }
    return $string;

}

function bold_words($string, $words)
{
    foreach ($words as $word) {
        $string = str_replace($word, "<b>$word</b>", $string);
    }
    return $string;
}

function italic_words($string, $words)
{
    foreach ($words as $word) {
        $string = str_replace($word, "<em>$word</em>", $string);
    }
    return $string;
}

function parse_resume($resume, $level = 1, $title = false)
{
    global $parser;
    $toReturn = '';
    static $in_li = 0;
    if ($level > 6) {
        $level = 6;
    }
    global $bold_words;
    global $italic_words;

    if (is_string($resume)) {
        if ($title) {
            $toReturn .= '<h' . $level . ' id="' . preg_replace("/[^a-zA-Z0-9]+/", "", strip_tags($resume)) . '" class="' . add_class($level, 'title') . '">' . $resume . '</h' . $level . '>';
        } else {
            $toReturn .= italic_words(bold_words(add_links($resume), $bold_words), $italic_words);
        }

    }

    if (is_array($resume) && !isAssoc($resume)) {
        if (!$in_li > 0 && count($resume) == 1) {
            $toReturn .= parse_resume(array_pop($resume), $level);
        } else {
            $in_li++;
            $toReturn .= '<ul>';
            foreach ($resume as $value) {
                if (isset($value)) {
                    $toReturn .= '<li>';
                    $toReturn .= parse_resume($value, $level);
                    $toReturn .= '</li>';
                }
            }
            $toReturn .= '</ul>';
            $in_li--;
        }
    }
    if (is_array($resume) && isAssoc($resume)) {
        $level++;
        foreach ($resume as $key => $value) {

            if (isset($value)) {
                if (is_string($value) && strlen($value) > 0) {
                    $toReturn .= '<b>' . $key . '</b>';
                    if (strlen($key) > 0) {
                        $toReturn .= ': ';
                    }
                } elseif ($value == null || (is_string($value) && strlen($value) == 0)) {

                    $value = $key;
                } elseif (is_array($value)) {
                    $toReturn .= parse_resume($key, $level, true);
                }
                $toReturn .= parse_resume($value, $level);
            }
        }
    }
    return $parser->parseParagraph($toReturn);
}

?>
<html>
<head>
    <title><?= $profile['name'] ?> Resume</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .link {
        cursor: pointer;
        text-decoration: underline;
        color: blue;
    }
</style>
<body data-theme="<?= $theme ?>">
<br/>
<br/>

<?php include('themes/' . $theme . '.php'); ?>
<hr/>
<hr/>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="lead text-center">
                    Generated using "VarunBatraIT/Resume-Generator-PHP-YAML", Source Codes available on <a
                        href="https://github.com/VarunBatraIT/Resume-Generator-PHP-YAML">Github</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', '<?=$analytics['google']?>', 'auto');
    //    ga('send', 'pageview');
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    $(document).ready(function (event) {
        var $body = $('body')
        ga('send', 'pageview', {
            'page': '/?theme=' + $body.attr('data-theme')
        });
        hashLinkTest = window.location.href.split('#')[0];
        //hash links looks different
        $('a').each(function () {
            var omitLink = this.href.split(hashLinkTest)[1];
            if (typeof omitLink == 'undefined') {
                return true;
            }
            if (omitLink[0] == '#') {
                //hash link
                $(this).css({
                    color: '#00C',
                    textDecoration: 'underline'
                });
            }
        });
        var hiddenText = $.parseJSON('<?=json_encode($hidden)?>');
        $.each(hiddenText, function (key, value) {
            var ele = $('a:contains(' + key + ')');
            ele.addClass('hidden').addClass('intentHidden');
            $('<span></span>').addClass('link').text(value).insertAfter(ele).on('click', function (event) {
                var $this = $(this);
                var link = $this.siblings('a.intentHidden');
                link.removeClass('hidden');
                $this.addClass('hidden');
                ga('send', {
                    'hitType': 'event',
                    'eventCategory': 'view',
                    'eventAction': $this.text(),
                    'eventLabel': link.text(),
                    'eventValue': 1
                });
            })
        });
    });
</script>
<script src="/bower_components/crazy-google-analytics/crazyGoogleAnalytics.js"></script>
</body>

</html>
