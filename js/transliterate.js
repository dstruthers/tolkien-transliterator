var g_transliterated = '';
var g_transliteratedFrom = '';
var g_transliteratedTo = '';
var g_tengwarClass = 'tengwar-formal';
var g_transliterationDirection = 0;
var g_lastTransliteration = 0;

$(function () {
    if (localStorage.tengwarClass) {
        g_tengwarClass = localStorage.tengwarClass;
        $('#tengwar-font').val(g_tengwarClass);
    }
    window.setInterval(checkForTransliterate, 1000);
    $('#tengwar-font').change(function () {
        var oldTengwarClass = g_tengwarClass;
        g_tengwarClass = $(this).val();
        localStorage.tengwarClass = g_tengwarClass;
        if (g_transliterationDirection == 0) {
            $('#result #text').removeClass(oldTengwarClass).addClass(g_tengwarClass);
        }
        else {
            $('#source textarea').removeClass(oldTengwarClass).addClass(g_tengwarClass);
        }
    });
    $('#swap-button').click(function () {
        g_transliterationDirection = !g_transliterationDirection;
        createTransliterationOptions();
    });
    $('#source-lang').change(transliterate);
    $('#result-lang').change(transliterate);
    createTransliterationOptions();
});

function createTransliterationOptions () {
    $('#source-lang').empty();
    $('#result-lang').empty();
    $('#source textarea').removeClass(g_tengwarClass);
    $('#result #text').removeClass(g_tengwarClass);
    if (g_transliterationDirection == 0) {
        $('#source-lang').append($('<option value="en">Latin Characters</option>'));
        $('#result-lang').append($('<option value="tengwar_orthographic">Tengwar (Orthographic)</option>'));
        $('#result-lang').append($('<option value="tengwar_phonetic">Tengwar (English Phonetic)</option>'));
        $('#result #text').addClass(g_tengwarClass);
    }
    else {
        $('#source-lang').append($('<option value="tengwar">Tengwar (Unicode PUA)</option>'));
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
           { data : 'source-lang=' + sourceLang + '&source=' + escape(source) + '&result-lang=' + resultLang,
             success : transliterateDone });
}
