var g_transliterated = '';
$(function () {
    window.setInterval(checkForTransliterate, 1000);
});

function checkForTransliterate () {
    var sourceText = $('#source textarea').val();
    if (sourceText !== g_transliterated) {
        transliterate();
        g_transliterated = sourceText;
    }
    $('#result #text').html();
}

function transliterate () {
    var sourceLang = $('#source-lang').val();
    var source = $('#source textarea').val();
    var resultLang = $('#result-lang').val();

    function transliterateDone (msg) {
        var result = $(msg);
        $('#result #text').html($('result text', result).text());
    }

    if (!$('#text').has('#loading').length) {
        $('#result #text').append($('<img id="loading" src="images/loading.gif"/>'));
    }
    $.ajax('transliterate.php',
           { data : 'source-lang=' + sourceLang + '&source=' + source + '&result-lang=' + resultLang,
             success : transliterateDone });
}
