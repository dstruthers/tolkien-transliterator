var g_transliterated = '';
var g_transliteratedFrom = '';
var g_transliteratedTo = '';
var g_tengwarClass = 'tengwar-formal';
var g_transliterationDirection = 0;
var g_lastTransliteration = 0;
var g_tengwarKeyboardCreated = false;
var g_tengwarKeyboardDisplayed = false;

$(function () {
    if (localStorage.tengwarClass) {
        g_tengwarClass = localStorage.tengwarClass;
        $('#tengwar-font').val(g_tengwarClass);
    }
    if (localStorage.wordSpacing) {
        $('#tengwar-word-spacing').val(localStorage.wordSpacing);
    }
    if (localStorage.numeralBase) {
        $('#tengwar-numeral-base').val(localStorage.numeralBase);
    }
    if (localStorage.numeralDir) {
        $('#tengwar-numeral-dir').val(localStorage.numeralDir);
    }
    window.setInterval(checkForTransliterate, 1000);
    $('#tengwar-font').change(function () {
        var oldTengwarClass = g_tengwarClass;
        g_tengwarClass = $(this).val();
        localStorage.tengwarClass = g_tengwarClass;
        $('.' + oldTengwarClass).removeClass(oldTengwarClass).addClass(g_tengwarClass);
    });
    $('#swap-button').click(function () {
        g_transliterationDirection = !g_transliterationDirection;
        createTransliterationOptions();
    });
    $('#source-lang').change(transliterate);
    $('#result-lang').change(transliterate);
    $('#tengwar-word-spacing').change(function () {
        localStorage.wordSpacing = $(this).val();
        transliterate();
    });
    $('#tengwar-numeral-base').change(function () {
        localStorage.numeralBase = $(this).val();
        transliterate();
    });
    $('#tengwar-numeral-dir').change(function () {
        localStorage.numeralDir = $(this).val();
        transliterate();
    });
    createTransliterationOptions();

    $('#toggle-tengwar-keyboard').click(toggleTengwarKeyboard);

    if (navigator.userAgent.toUpperCase().indexOf('FIREFOX') == -1 && localStorage.noticeDismissed != 'dismissed') {
        $('#notice').html('Hey! Use <a href="http://getfirefox.com/" target="_blank">Mozilla Firefox</a> for the best results with this tool. <a href="#" id="dismiss-notice">Dismiss</a>');
        $('#notice').slideDown();
    }

    $('#dismiss-notice').click(function () {
        $('#notice').slideUp();
        localStorage.noticeDismissed = 'dismissed';
    });
});

function toggleTengwarKeyboard () {
    if (!g_tengwarKeyboardCreated) {
        TengwarKeyboard($('#tengwar-keyboard').get(0), $('#source textarea').get(0), g_tengwarClass);
        $('.tengwar-keyboard-close-button').click(toggleTengwarKeyboard);
        g_tengwarKeyboardCreated = true;
        g_tengwarKeyboardDisplayed = true;
    }
    else {
        if (g_tengwarKeyboardDisplayed) {
            $('#tengwar-keyboard').hide();
        }
        else {
            $('#tengwar-keyboard').show();
        }
        g_tengwarKeyboardDisplayed = !g_tengwarKeyboardDisplayed;
    }
    $('#toggle-tengwar-keyboard').html(g_tengwarKeyboardDisplayed ? 'Hide Tengwar Keyboard' : 'Show Tengwar Keyboard');
    return false;
}

function createTransliterationOptions () {
    $('#source-lang').empty();
    $('#result-lang').empty();
    $('#source textarea').removeClass(g_tengwarClass);
    $('#result #text').removeClass(g_tengwarClass);
    if (g_transliterationDirection == 0) {
        $('#source-lang').append($('<option value="en">Latin Characters</option>'));
        $('#result-lang').append($('<option value="tengwar_orthographic">Tengwar (English Orthographic)</option>'));
        $('#result-lang').append($('<option value="tengwar_phonetic">Tengwar (English Phonetic)</option>'));
        $('#result #text').addClass(g_tengwarClass);
    }
    else {
        $('#source-lang').append($('<option value="tengwar">Tengwar (Unicode Private Use Area)</option>'));
        $('#result-lang').append($('<option value="latin_common">Latin Characters (Common Mode)</option>'));
        $('#source textarea').addClass(g_tengwarClass);
    }
}

function checkForTransliterate () {
    var sourceText = $('#source textarea').val();
    var sourceLang = $('#source-lang').val();
    var resultLang = $('#result-lang').val();
    if (sourceText !== g_transliterated || sourceLang !== g_transliteratedFrom || resultLang != g_transliteratedTo) {
        transliterate();
        g_transliterated = sourceText;
    }
}

function transliterate () {
    var sourceLang = $('#source-lang').val();
    var source = $('#source textarea').val();
    var resultLang = $('#result-lang').val();
    var numBase = $('#tengwar-numeral-base').val();
    var numDir = $('#tengwar-numeral-dir').val();
    var wordSpacing = $('#tengwar-word-spacing').val();

    function transliterateDone (msg) {
        var time = $('time', $(msg)).text() * 1;
        if (time > g_lastTransliteration) {
            g_lastTransliteration = time;
            g_transliteratedFrom = $('source lang', $(msg)).text();
            g_transliteratedTo = $('result lang', $(msg)).text();
            var result = $('result text', $(msg)).text();
            result = result.replace(/\n/g, '<br/>').replace(' ', '&#160;');
            $('#result #text').html(result);
        }
    }

    if (!$('#text').has('#loading').length) {
        $('#result #text').append($('<img id="loading" src="images/loading.gif"/>'));
    }
    $.ajax('transliterate.php',
           { data : 'source-lang=' + sourceLang + '&source=' + escape(source) + '&result-lang=' + resultLang + '&ws=' + wordSpacing + '&nb=' + numBase + '&nd=' + numDir,
             success : transliterateDone });
}
