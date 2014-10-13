function TengwarKeyboard (element, inputElement, tengwarClass) {
    var div = $('<div class="tengwar-keyboard-container"></div>');
    div.append($('<div class="tengwar-keyboard-title">Tengwar Keyboard<a href="#" class="tengwar-keyboard-close-button">X</a></div>'));
    var tengwar = [['E000', 'Tinco'],
                   ['E001', 'Parma'],
                   ['E002', 'Calma'],
                   ['E003', 'Quesse'],

                   ['E004', 'Ando'],
                   ['E005', 'Umbar'],
                   ['E006', 'Anga'],
                   ['E007', 'Ungwë'],

                   ['E008', 'Thúlë'],
                   ['E009', 'Formen'],
                   ['E00A', 'Harna'],
                   ['E00B', 'Hwesta'],

                   ['E00C', 'Anto'],
                   ['E00D', 'Ampa'],
                   ['E00E', 'Anca'],
                   ['E00F', 'Unquë'],

                   ['E010', 'Númen'],
                   ['E011', 'Malta'],
                   ['E012', 'Ngoldo'],
                   ['E013', 'Ngwalmë'],

                   ['E014', 'Órë'],
                   ['E015', 'Vala'],
                   ['E016', 'Anna'],
                   ['E017', 'Vilya'],

                   ['E020', 'Rómen'],
                   ['E021', 'Arda'],
                   ['E022', 'Lambë'],
                   ['E023', 'Alda'],

                   ['E024', 'Silmë'],
                   ['E025', 'Silmë nuquerna'],
                   ['E026', 'Essë'],
                   ['E027', 'Essë nuquerna'],

                   ['E028', 'Hyarmen'],
                   ['E029', 'Hwesta sindarinwa'],
                   ['E02A', 'Yanta'],
                   ['E02B', 'Úrë']];

    var tengwarTable = $('<table></table>');
    //tengwarTable.append($('<tr><td></td><th>I</th><th>II</th><th>III</th><th>IV</th></tr>'));
    for (var ir = 0; ir < 9; ir++) {
        var row = $('<tr></tr>');
        //row.append('<th>' + (ir + 1) + '</th>');
        for (var ic = 0; ic < 4; ic++) {
            var col = $('<td></td>');
            var button = $('<span>' + unescape('%u' + tengwar[ir * 4 + ic][0]) + '</span>');
            button.addClass('tengwar-keyboard-button').addClass(tengwarClass);
            button.addClass('tengwar-keyboard-button-' + ir + '-' + ic);
            button.mouseover(function () {
                var matches = $(this).attr('class').match(/tengwar\-keyboard\-button\-([0-9]+)\-([0-9]+)/);
                var r = matches[1] * 1, c = matches[2] * 1;
                var tengwa = tengwar[r * 4 + c];
                $('.tengwar-keyboard-description').html('U+' + tengwa[0] + ' ' + tengwa[1]);
            });
            button.mouseout(function () {
                $('.tengwar-keyboard-description').html('&#160;');
            });
            button.click(function () {
                var matches = $(this).attr('class').match(/tengwar\-keyboard\-button\-([0-9]+)\-([0-9]+)/);
                var r = matches[1] * 1, c = matches[2] * 1;
                var tengwa = unescape('%u' + tengwar[r * 4 + c][0]);
                // MSIE
                if (document.selection) {
                    inputElement.focus();
                    var sel = document.selection.createRange();
                    sel.text = tengwa;
                }
                // Real browsers
                else if (inputElement.selectionStart || inputElement.selectionStart == '0') {
                    var startPos = inputElement.selectionStart;
                    var endPos = inputElement.selectionEnd;
                    inputElement.value = inputElement.value.substring(0, startPos) + tengwa + inputElement.value.substring(endPos, inputElement.value.length);
                }
                else {
                    inputElement.value += tengwa;
                }
                inputElement.focus();
                return false;
            });
            col.append(button);
            row.append(col);
        }
        tengwarTable.append(row);
    }

    var tehtar = [['E02E', 'Short carrier'],
                  ['E02C', 'Long carrier'],
                  ['E040', 'A tehta'],
                  ['E046', 'E tehta'],
                  ['E044', 'I tehta'],
                  ['E04A', 'O tehta'],
                  ['E04C', 'U tehta'],
                  ['E045', 'Underdot'],
                  ['E050', 'Overbar'],
                  ['E051', 'Underbar'],
                  ['E058', 'S hook'],
                  null,
                  ['E070', 'Tengwar numeral 0'],
                  ['E071', 'Tengwar numeral 1'],
                  ['E072', 'Tengwar numeral 2'],
                  ['E073', 'Tengwar numeral 3'],
                  ['E074', 'Tengwar numeral 4'],
                  ['E075', 'Tengwar numeral 5'],
                  ['E076', 'Tengwar numeral 6'],
                  ['E077', 'Tengwar numeral 7'],
                  ['E078', 'Tengwar numeral 8'],
                  ['E079', 'Tengwar numeral 9'],
                  ['E07A', 'Tengwar numeral 10 (A)'],
                  ['E07B', 'Tengwar numeral 11 (B)'],
                  ['E01C', 'The'],
                  ['E01D', 'Of']
                 ];

    var tehtarTable = $('<table></table>');
    var row = $('<tr></tr>');
    //tehtarTable.append($('<tr><th>&#160;</th></tr>'));

    for (var i = 0; i < tehtar.length; i++) {
        if (i && i % 4 === 0) {
            tehtarTable.append(row);
            row = $('<tr></tr>');
        }
        if (!tehtar[i]) {
            col = $('<td></td>');
            row.append(col);
            continue;
        }
        col = $('<td></td>');
        button = $('<span>' + unescape('%u' + tehtar[i][0]) + '</span>');
        button.addClass('tengwar-keyboard-button').addClass(tengwarClass);
        button.addClass('tengwar-keyboard-button-tehta-' + i);
        button.mouseover(function () {
            var matches = $(this).attr('class').match(/tengwar\-keyboard\-button\-tehta-([0-9]+)/);
            var i = matches[1] * 1;
            var tehta = tehtar[i];
            $('.tengwar-keyboard-description').html('U+' + tehta[0] + ' ' + tehta[1]);
        });
        button.mouseout(function () {
            $('.tengwar-keyboard-description').html('&#160;');
        });
        button.click(function () {
            var matches = $(this).attr('class').match(/tengwar\-keyboard\-button\-tehta-([0-9]+)/);
            var i = matches[1] * 1;
            var tehta = unescape('%u' + tehtar[i][0]);
            // MSIE
            if (document.selection) {
                inputElement.focus();
                var sel = document.selection.createRange();
                sel.text = tehta;
            }
            // Real browsers
            else if (inputElement.selectionStart || inputElement.selectionStart == '0') {
                var startPos = inputElement.selectionStart;
                var endPos = inputElement.selectionEnd;
                inputElement.value = inputElement.value.substring(0, startPos) + tehta + inputElement.value.substring(endPos, inputElement.value.length);
            }
            else {
                inputElement.value += tehta;
            }
            inputElement.focus();
            return false;
        });
        col.append(button);
        row.append(col);
    }
    tehtarTable.append(row);

    var layoutTable = $('<table></table>');
    var tr = $('<tr></tr>');
    var td = $('<td></td>');
    td.css('vertical-align', 'top');
    //td.append('<p><strong>TENGWAR</strong></p>');
    td.append(tengwarTable);
    tr.append(td);
    td = $('<td></td>');
    td.css('vertical-align', 'top'); 
    //td.append('<p><strong>TEHTAR</strong></p>');
    td.append(tehtarTable);
    tr.append(td);
    layoutTable.append(tr);
    div.append(layoutTable);
    div.append($('<p class="tengwar-keyboard-description">&#160;</p>'));
    $(element).append(div);
    $(element).css('display', 'inline-block');
    $(element).draggable();
}